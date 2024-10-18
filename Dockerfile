FROM php:8.1-fpm

# Встановлюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Встановлюємо додаткові PHP-розширення
RUN apt-get update && apt-get install -y libpq-dev git \
    && docker-php-ext-install pdo pdo_pgsql

# Вказуємо робочу директорію
WORKDIR /var/www/html
