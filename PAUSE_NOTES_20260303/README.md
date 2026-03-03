# 暂停记录（2026-03-03）

## 本轮新增错误与处理

### 1) 添加 Eagle 库时报错
- 现象：`System Error`，提示 `Non-static method dzz_io::checkfileexists() cannot be called statically`。
- 调用栈位置：`dzz/pichome/library/index.php:873`。
- 原因：PHP 8.1 下禁止把非静态方法以静态方式调用。
- 修复：将 `dzz_io` 中相关方法改为静态可调用，兼容项目中大量 `IO::checkfileexists(...)` 写法。
  - 文件：`core/class/dzz/dzz_io.php`
  - 调整：`initIO` / `clean` / `clean_path` / `checkfileexists`。

### 2) 浏览器控制台报错
- 现象：`Uncaught SyntaxError: Unexpected token '<' (at misc.php?mod=upgrade...:1:1)`。
- 含义：前端期望 JS/JSON，后端返回了 HTML（通常是错误页）。
- 修复：增强 `misc/upgrade.php` 的参数与数据兜底，避免在 ajax 轮询时回 HTML。
  - 文件：`misc/upgrade.php`
  - 调整：
    - `action` 安全读取。
    - `upgradenotice` 分支对 `$_G['setting']['upgrade']` 做数组与字段兜底。
    - 未知 `action` + `isajax=1` 时返回空 JSON：`{"data":[]}`。

## 备注
- 当前仓库里未发现旧的 `PAUSE_NOTES_20260303/README.md`，本次已重新创建。

## 本轮继续修复（2026-03-03 16:48）

### 3) 库更新按钮报错 `json is not defined`
- 现象：`index.php?mod=pichome&op=library` 控制台报 `ReferenceError: json is not defined`（`TableRefresh`）。
- 原因：axios 响应解构为 `res`，错误分支却读取 `json.error`。
- 修复：改为 `res.error`。
  - `dzz/pichome/template/storehouse/pc/components/library/main.htm`
  - `dzz/pichome/template/storehouse/pc/components/library/main copy.htm`

### 4) fileview 页面 `Undefined constant "uid"`
- 现象：`index.php?mod=pichome&op=fileview&id=...` 报 `Undefined constant "uid"`。
- 原因：模板内 `{eval ...}` 使用 `avatar_block($_G[uid])`，在 PHP 8.1 下会触发未定义常量错误。
- 修复：统一替换为 `avatar_block($_G["uid"])`（全仓相关模板）。

### 5) `$_G['setting'][sitename]` 兼容性风险
- 现象：存在 `$_G['setting'][sitename]` 这种未加引号的二级键写法。
- 风险：在 PHP 8.1 下会触发未定义常量（取决于执行路径）。
- 修复：统一替换为 `$_G['setting']["sitename"]`（全仓相关模板）。

### 6) 静态审查 + 回归结果
- 静态审查：
  - 非静态方法被静态调用扫描：`NO_STATIC_CALL_ISSUES`。
  - 模板 `{eval ... $_G[uid] ...}` 扫描：已清零。
- 回归访问（本机启动后 `curl`）：
  - `mod=pichome&op=library`
  - `mod=pichome&op=fileview&id=fd8tW3`
  - `mod=stats&op=downloads`
  - `mod=stats&op=views`
  - `mod=alonepage`
  - `mod=banner&op=admin`
  - `mod=manage`
- 结果：上述页面响应均为 HTTP 200，响应体未检出 `System Error / Undefined constant / Warning / Deprecated` 关键词。

### 7) 额外动作
- 已清理模板编译缓存：`data/template/*.tpl.php`，避免旧编译文件继续触发历史错误。

## 固定处理流程（已更新）
1. 先改代码（最小改动修复当前错误）。
2. 做静态审查（同类风险全量扫描，不等运行时报错）。
3. 清理缓存（至少清 `data/template/*.tpl.php`）。
4. 重启本地服务（PHP 8.1，端口 `18084`）。
5. 回归测试（我本地直接访问目标 URL + 检查错误标记）。

## Bug 固定步骤（执行版）
1. 记录问题：写入「URL + 现象 + 报错原文 + 时间」到本文件。
2. 先修当前点：仅改最小必要代码，避免扩大改动面。
3. 静态审查同类风险：全量扫描同模式（如 `$_G[uid]`、静态调非静态、未判空数组键）。
4. 补齐防御：对 `$_GET/$_POST/$_G` 的可空键加 `isset/!empty` 兜底。
5. 语法检查：`php -l` 检查改动的 PHP/模板编译输出。
6. 清缓存：删除 `data/template/*`，必要时清 `data/cache/*`。
7. 重启服务：重启 `127.0.0.1:18084` 的 PHP 8.1 服务。
8. 回归测试：逐个访问受影响 URL，并检查浏览器控制台首条错误。
9. 结果回写：把「根因、改动文件、验证结果、遗留风险」回填到本文件。

## 本轮继续修复（2026-03-03 17:00）
### 8) `systeminfo` 报错 `gmmktime(): Argument #2 ($minute) must be of type ?int, string given`
- 根因：`core/class/dzz/dzz_cron.php` 的 `setnextime()` 中，`gmmktime()` 参数直接使用了字符串值。
- 修复：在调用前显式 `intval` 转换 `hour/minute/day/month/year`。
  - 文件：`core/class/dzz/dzz_cron.php:96`
- 回归：
  - 已清模板缓存并重启 `127.0.0.1:18084` 服务。
  - 访问 `index.php?mod=systeminfo` 返回 200，页面未检出 `System Error/Fatal/TypeError` 关键词。

## 本轮继续修复（2026-03-03 18:14）
### 9) 库已存在但库管理列表不显示（`/index.php?mod=pichome&op=library`）
- 数据核查：数据库 `pichome_pichome_vapp` 已存在记录（`appid=fd8tW3`，`isdelete=0`，路径 `/Users/xasxcy/Downloads/我的灵感.library`）。
- 根因：`dzz/class/class_encode.php` 中 `Encode_Core::get_encoding()` 为静态方法，但内部调用了非静态 `detect_utf_encoding()`，PHP 8.1 下会触发静态调用非静态方法错误，导致库列表数据处理链路异常。
- 修复：将 `detect_utf_encoding` 改为 `private static`。
  - 文件：`dzz/class/class_encode.php`
- 流程执行：已清模板缓存、重启 18084 服务并确认页面可返回 200。

## 本轮继续修复（2026-03-03 19:15）
### 10) Eagle 导入卡死（`state=2, percent=0`）
- 现象：`fd8tW3` 长时间停在 `state=2/percent=0`，导出锁存在但进度不变。
- 排查与修复：
  - 修复 `core/class/io/io_dzz.php`：`checkfileexists()` 中 `fopen` 失败后错误 `fclose(false)`（PHP 8.1 致命）。
  - 修复 `core/class/table/table_pichome_folderresources.php`：`TIMESTMP` 拼写错误为 `TIMESTAMP`；并修复 `unset(rid)` 后继续使用 `rid` 的逻辑。
  - 修复 `core/class/table/table_pichome_folder.php`：`unset(fid)` 后仍引用导致 warning。
  - 修复 `dzz/eagle/class/class_eagleexport.php`：`star/tag/duration` 键访问加 `!empty` 兜底。
  - 修复 `core/class/table/table_pichome_vapp.php`：`fileds.options` 缺省值兜底。
- 状态恢复：
  - 已通过框架内 `dzz_process::unlock(...)` 释放 `fd8tW3` 导出相关锁并重触发导出。
  - 进度已恢复增长：`donum` 从 `0` 提升到 `2431`，`percent` 到 `42`（持续增长中）。

### 11) fileview 顶部布局异常（tpl line 317）
- 现象：`fileview` 页面右上角出现模板 warning 文本。
- 修复：将模板内 `upgrade` 判断统一改为 `!empty($_G['setting']['upgrade'])`，避免未定义键 warning 破坏布局。
