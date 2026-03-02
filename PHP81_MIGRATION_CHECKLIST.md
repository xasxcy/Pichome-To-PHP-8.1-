# PHP 8.1 迁移清单（Pichome-2.2.0）

## 0. 当前状态（已完成）
- [x] 安装 PHP 8.1：`brew install php@8.1`
- [x] 使用 PHP 8.1 CLI 验证：`/opt/homebrew/opt/php@8.1/bin/php -v`（8.1.34）
- [x] 去除安装器中的 PHP 版本上限检测（此前已改）
- [x] 修复安装器 `get_magic_quotes_gpc()` 在 PHP 8.x 的兼容调用（此前已改）
- [x] 修复安装阶段数据库连接在 PHP 8.1 下抛 `mysqli_sql_exception` 导致的 Fatal

## 1. 语法体检结果（PHP 8.1）
- 扫描范围：排除 `vendor/` 的全部 PHP 文件
- 扫描命令：`php -l`
- 初始结果：`TOTAL=843`, `FAIL=28`
- 当前结果：`TOTAL=843`, `FAIL=0`（非 `vendor`）

### 1.1 阻断级（必须修复，否则 PHP 8.1 无法运行到相关路径）
- [ ] **`{}` 字符串/数组下标语法**（PHP 8 移除）
  - 典型文件：
    - `core/function/function_seccode.php`
    - `core/class/cache/cache_file.php`
    - `admin/setting/index.php`
    - `admin/setting/interface.php`
    - `core/class/class_Des.php`
    - `core/class/class_GifMerge.php`
    - `core/class/PHPExcel/*`（大量）
- [ ] **未加括号的嵌套三元表达式**（PHP 8 不支持）
  - `core/function/function_core.php:1584`
- [ ] **类常量默认值里含非法表达式**
  - `core/class/class_Wechat.php:4155`
  - `core/class/class_qyWechat.php:1947`

### 1.2 警告级（建议修复）
- [ ] **可选参数在必选参数之前**（PHP 8.1 Deprecated）
  - `core/function/function_core.php:547`
  - `core/class/class_Wechat.php:3599`
  - `core/class/class_qyWechat.php:702`
- [ ] `continue` 在 `switch` 里的语义警告
  - `core/class/PHPExcel/Shared/OLE.php:290`

## 2. 第三方库专项建议
- [ ] **PHPExcel**：当前版本对 PHP 8.1 不友好，建议二选一
  - 路径 A：批量替换 `{}` 为 `[]` 并修复语法告警（短期可用，维护成本高）
  - 路径 B：迁移到 `PhpSpreadsheet`（中长期建议）
- [ ] 微信相关 SDK（`class_Wechat.php`、`class_qyWechat.php`）做专项升级或补丁

## 3. 运行时验证清单（修复语法后执行）
- [x] 未安装态：首页/用户端/后台入口可访问并正确跳转安装页（HTTP 302）
- [x] 安装页步骤 `env_check` / `dir_check` / `db_init` / `admin_init` 可访问（HTTP 200）
- [x] `db_init` 提交错误数据库凭据时返回友好错误页，不再 Fatal
- [ ] 上传、缩略图、预览、转码任务可执行（需完整安装后验证）
- [ ] 定时任务（cron）可触发且无 fatal（需完整安装后验证）
- [ ] 管理后台设置页可打开并保存（需完整安装后验证）
- [ ] 导入/导出（尤其 Excel）可用（需完整安装后验证）
- [ ] AI/外部模块（如 `aiXhimage`）按需验证（需完整安装后验证）

## 4. 我建议的落地顺序
- [ ] 第 1 批：修核心阻断文件（`function_core.php`、`function_seccode.php`、`cache_file.php`、`admin/setting/*`）
- [ ] 第 2 批：处理微信 SDK 两个文件的常量与函数签名
- [ ] 第 3 批：处理 PHPExcel（优先替换为 PhpSpreadsheet，或先做语法补丁）
- [ ] 第 4 批：全量 `php -l` + 业务回归 + 压测

## 5. 本地测试命令（固定 PHP 8.1）
```bash
PHPBIN=/opt/homebrew/opt/php@8.1/bin/php
$PHPBIN -v
$PHPBIN -l index.php

# 全量语法检查（排除 vendor）
rg --files -g '*.php' | rg -v '(^|/)vendor/' | while read -r f; do
  "$PHPBIN" -l "$f" >/dev/null || echo "FAIL: $f"
done
```
