FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]