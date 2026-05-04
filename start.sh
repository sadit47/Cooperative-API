#!/bin/sh

# fix port
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf

# fix MPM
a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork

# 🔥 สำคัญมาก (จะเห็น error จริง)
php artisan migrate --force || true
php artisan config:clear || true
php artisan cache:clear || true

# 🔥 DEBUG: print log ออก console
tail -f storage/logs/laravel.log &

apache2-foreground