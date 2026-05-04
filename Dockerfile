FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

# ✅ เพิ่มตรงนี้ (สำคัญมาก)
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

COPY apache.conf /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["start.sh"]