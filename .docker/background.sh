#!/bin/bash

set -e

echo "📁 Asegurando estructura de carpetas..."
mkdir -p storage/framework/{sessions,views,cache/data}
mkdir -p storage/app/public
mkdir -p storage/logs

if [ "$APP_ENV" = "production" ] || [ "$APP_ENV" = "release" ]; then
    echo "🔐 Volcando variables de entorno en .env"
    env > .env
fi

if [ "$APP_PERMISSIONS" = "production" ]; then
    echo "🔧 Asignando permisos de carpetas..."
    chmod -R 777 storage
    chown -R www-data:www-data .
fi

if [ "$APP_ENV" = "local" ]; then
  echo "🔧 Asignando permisos de carpetas..."
  chmod -R 777 storage vendor public node_modules

  echo "📦 Entorno local detectado. Ejecutando dependencias forzadamente..."

  echo "📦 Ejecutando 'composer install'..."
  composer install
  composer dump-autoload

  echo "📦 Ejecutando 'npm install'..."
  npm install
  npm run build
fi

echo "✅ Preparación de entorno completada"
