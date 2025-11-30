FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# SỬA: Copy thẳng vào file config mặc định của Linux (không dùng conf.d)
COPY supervisord.conf /etc/supervisor/supervisord.conf
RUN mkdir -p /var/log/supervisor

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000 8080

ENTRYPOINT ["docker-entrypoint.sh"]