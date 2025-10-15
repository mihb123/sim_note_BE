# Use PHP 8.2 image with FPM
FROM php:8.2-fpm

# Install necessary extensions for Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the entire source code into the container
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for storage & bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
