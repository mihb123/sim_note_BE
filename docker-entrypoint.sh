#!/bin/bash
set -e
echo "Setting up environment..."

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

php artisan migrate:fresh --seed

echo "Starting Supervisor (PHP-FPM + Reverb + Queue)..."

exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf