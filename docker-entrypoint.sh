#!/bin/bash
set -e
echo "Setting up environment..."
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi
php artisan migrate:fresh --seed
php-fpm
echo "Starting PHP-FPM..."
exec "$@"