#!/bin/sh

sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf

# fix MPM
a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork

# 🔥 สร้าง .env ถ้ายังไม่มี
if [ ! -f .env ]; then
  cp .env.example .env
fi

# 🔥 inject APP_KEY จาก Railway
php artisan key:generate --force || true

# 🔥 clear config
php artisan config:clear || true
php artisan cache:clear || true

# 🔥 create log file กัน tail พัง
mkdir -p storage/logs
touch storage/logs/laravel.log

# debug log
tail -f storage/logs/laravel.log &

apache2-foreground