#!/bin/sh

sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf

# fix MPM
a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork

# 🔥 auto migrate
php artisan migrate --force
php artisan db:seed --force

apache2-foreground