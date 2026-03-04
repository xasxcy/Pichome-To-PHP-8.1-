# Pichome 本地开发服务器说明

## 一、为什么不用 `php -S`？

`php -S`（PHP 内置服务器）是**单线程**的，同一时间只能处理一个请求。
Pichome 的"更新库"功能会触发一个**链式循环导入**：

```
initexport → exportfile（批处理 100 文件）→ exportfile → exportfile → ...
```

每次 `exportfile` 调用都要对每张图片执行 `getimagesize()` 读取宽高、写入多张数据库表，耗时可达数秒至数十秒。在这段时间内，内置服务器**完全无法响应其他任何请求**，导致主页、库页面等全部无限加载。

以"灰金品质"（3182 个文件）为例，按每批 100 文件需 32 次链式调用，服务器可能被占用数分钟。

---

## 二、推荐方案：PHP-FPM + Nginx

**PHP-FPM** 是多进程的，导入任务运行在独立的 worker 进程中，不影响其他页面请求。

### 启动命令

在项目根目录执行一次即可：

```bash
bash start.sh
```

脚本会自动完成：
1. 生成 php-fpm 配置（端口 9081，以当前用户运行）
2. 生成 nginx vhost 配置（端口 18084，写入 `/opt/homebrew/etc/nginx/servers/pichome.conf`）
3. 启动 php-fpm 和 nginx

启动后访问：**http://127.0.0.1:18084**

### 停止服务

```bash
# 停止 php-fpm
kill $(cat /tmp/pichome-fpm.pid)

# 停止 nginx（若不需要 nginx 提供其他服务）
nginx -s stop
# 或仅去掉 pichome vhost 再重载
rm /opt/homebrew/etc/nginx/servers/pichome.conf && nginx -s reload
```

### 日志位置

| 日志 | 路径 |
|------|------|
| php-fpm 错误 | `/tmp/pichome-fpm-error.log` |
| PHP 脚本错误 | `/tmp/pichome-php-error.log` |
| nginx 错误 | `/tmp/pichome-nginx-error.log` |

---

## 三、"更新库"做了什么

点击库管理页面的"更新"按钮会触发三个阶段：

### 阶段 1 — 扫描（`misc.php?mod=initexport`）
- 递归遍历库目录，把所有文件的完整路径写入 `data/attachment/cache/loaclexport{md5}.txt`
- 将 vapp 状态设为 `state=2`（导入中）

### 阶段 2 — 导入（`misc.php?mod=exportfile`，循环链式）
对 txt 清单中每个文件（每批最多 100 个）：
- `is_file()` 确认文件存在
- `filesize()` / `filemtime()` 读取大小和修改时间
- 对图片文件调用 `getimagesize()` 读取宽高（只读文件头，不读取全部内容）
- 将元数据写入数据库：`pichome_resources`、`local_record`、`pichome_folder`、`thumb_record` 等
- **不下载、不复制文件本身**，仅建立索引，路径指向原始位置
- 批次完成后通过 `dfsockopen` 异步触发下一批（fire-and-forget）

### 阶段 3 — 校验（`misc.php?mod=exportfilecheck`）
- 验证数据库记录完整性
- 清理孤立的目录记录
- 将状态设为 `state=4`（完成），此时 `donum`/`percent` 会被重置为 0（正常行为）

### 关于缩略图
缩略图由独立的 `thumbconvertrecord` 流程按需异步生成，与导入流程分离。
导入完成后，首次访问图片时才触发缩略图生成。

---

## 四、WebDAV / 挂载目录

只要 WebDAV 目录已通过 macOS Finder（或 `mount`）挂载到本地文件系统，PHP 的 `readdir()`、`is_file()` 等函数对其与本地目录完全透明，无需额外配置。
