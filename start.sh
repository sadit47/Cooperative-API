#!/bin/sh

echo "PORT is: $PORT"

# ถ้า Railway ไม่ส่งมา → fallback
if [ -z "$PORT" ]; then
  echo "PORT not set, fallback to 8080"
  PORT=8080
fi

# 🔥 ใช้ตัวแปรจริง (สำคัญมาก)
php artisan serve --host=0.0.0.0 --port=$PORT