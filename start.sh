#!/usr/bin/env bash
# Pichome 开发服务器启动脚本（PHP-FPM + Nginx）
# 解决 `php -S` 单线程导致大库更新时页面卡死的问题

set -e
PROJECT_DIR="$(cd "$(dirname "$0")" && pwd)"
PORT=18084
FPM_PORT=9081
FPM_CONF=/tmp/pichome-fpm.conf
FPM_PID=/tmp/pichome-fpm.pid
NGINX_VHOST=/opt/homebrew/etc/nginx/servers/pichome.conf
USER=$(whoami)

# ── 1. 生成 php-fpm 配置（以当前用户运行，独立端口 9081）─────────────
cat > "$FPM_CONF" << FPMEOF
[global]
pid = $FPM_PID
error_log = /tmp/pichome-fpm-error.log
daemonize = yes

[pichome]
user = $USER
group = staff
listen = 127.0.0.1:$FPM_PORT
listen.owner = $USER
listen.group = staff
pm = dynamic
pm.max_children = 10
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 5
php_admin_value[error_log] = /tmp/pichome-php-error.log
php_admin_flag[log_errors] = on
php_admin_value[memory_limit] = 256M
FPMEOF

# ── 2. 生成 nginx vhost 配置（端口 18084，路由规则与 .htaccess 一致）──
cat > "$NGINX_VHOST" << NGINXEOF
server {
    listen $PORT;
    server_name localhost;
    root $PROJECT_DIR;
    index index.php;

    # 静态文件直接返回，找不到时交给 index.php（与 .htaccess RewriteRule 等效）
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # PHP 请求转发给 php-fpm
    location ~ \.php\$ {
        fastcgi_pass  127.0.0.1:$FPM_PORT;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include       fastcgi_params;
        # 超时设置：大库导入单次批处理可能耗时较长
        fastcgi_read_timeout 300;
    }

    # 禁止访问敏感文件
    location ~ /\.(ht|git) { deny all; }

    error_log  /tmp/pichome-nginx-error.log;
    access_log off;
}
NGINXEOF

# ── 3. 停止旧进程（如有）────────────────────────────────────────────────
if [ -f "$FPM_PID" ] && kill -0 "$(cat "$FPM_PID")" 2>/dev/null; then
    echo "停止旧 php-fpm 进程..."
    kill "$(cat "$FPM_PID")"
    sleep 1
fi
# 也清理掉 php -S 内置服务器（如果还在运行）
lsof -ti:$PORT | xargs kill 2>/dev/null || true

# ── 4. 启动 php-fpm ─────────────────────────────────────────────────────
echo "启动 php-fpm (端口 $FPM_PORT, 用户 $USER)..."
/opt/homebrew/opt/php@8.1/sbin/php-fpm -y "$FPM_CONF"
sleep 1
if [ -f "$FPM_PID" ] && kill -0 "$(cat "$FPM_PID")" 2>/dev/null; then
    echo "  ✓ php-fpm 运行中 (PID $(cat "$FPM_PID"))"
else
    echo "  ✗ php-fpm 启动失败，查看 /tmp/pichome-fpm-error.log"
    exit 1
fi

# ── 5. 启动/重载 nginx ──────────────────────────────────────────────────
if nginx -t -q 2>/dev/null; then
    if pgrep -x nginx > /dev/null; then
        echo "重载 nginx 配置..."
        nginx -s reload
    else
        echo "启动 nginx..."
        nginx
    fi
    echo "  ✓ nginx 运行中"
else
    echo "  ✗ nginx 配置有误，运行 'nginx -t' 查看详情"
    exit 1
fi

echo ""
echo "Pichome 已启动：http://127.0.0.1:$PORT"
echo ""
echo "停止服务："
echo "  php-fpm: kill \$(cat $FPM_PID)"
echo "  nginx:   nginx -s stop"
