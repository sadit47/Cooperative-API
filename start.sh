#!/bin/sh

# 🔥 สร้าง .env ถ้ายังไม่มี
if [ ! -f .env ]; then
  cp .env.example .env
fi

# 🔥 ใช้ APP_KEY จาก Railway (ถ้ามีจะไม่ทับ)
php artisan key:generate --force || true

# 🔥 clear cache
php artisan config:clear || true
php artisan cache:clear || true

# 🔥 migrate (กัน DB ยังไม่มา)
php artisan migrate --force || true

# 🔥 รัน Laravel ตรง ๆ (ไม่ใช้ Apache)
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}