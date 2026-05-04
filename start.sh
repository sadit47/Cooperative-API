#!/bin/sh

if [ -z "$PORT" ]; then
  PORT=8080
fi

# setup env
if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan key:generate --force || true
php artisan config:clear || true
php artisan cache:clear || true

# 🔥 สำคัญมาก
php artisan migrate --force || true
php artisan db:seed --force || true

php artisan serve --host=0.0.0.0 --port=$PORT