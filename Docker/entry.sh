#!/bin/sh
set -eu

cd /app

if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan config:clear || true
php artisan key:generate --force || true
php artisan migrate --force || true
php artisan db:seed --force || true
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
