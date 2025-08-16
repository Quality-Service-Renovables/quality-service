#!/bin/bash

set -e
set -o pipefail

echo "▶ Ejecutando background.sh para tareas previas..."
bash /scripts/background.sh || {
    echo "❌ Error al ejecutar background.sh"
    exit 1
}

echo "▶ Iniciando servicios..."

echo "🔧 Iniciando PHP-FPM..."
service php8.3-fpm start || {
    echo "❌ Error al iniciar PHP-FPM"
    exit 1
}

echo "🔧 Iniciando cron..."
service cron start || {
    echo "❌ Error al iniciar cron"
    exit 1
}

echo "🔧 Iniciando SSH..."
service ssh start || {
    echo "❌ Error al iniciar SSH"
    exit 1
}

echo "🌐 Iniciando NGINX (modo foreground)..."
nginx -g "daemon off;" &

echo "📜 Visualizando logs de NGINX y cron..."
tail -F /var/log/nginx/access.log /var/log/nginx/error.log /var/log/cron.log
