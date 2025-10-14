#!/bin/bash
set -e
echo "Setting up environment..."
php artisan key:generate
php artisan migrate:fresh --seed
echo "Starting PHP-FPM..."
exec "$@"