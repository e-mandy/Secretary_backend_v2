#!/bin/sh
set -eu

cd /app

if [ ! -f .env ]; then
  cp .env.example .env
fi

php artisan config:clear || true
php artisan key:generate --force || true

attempt=0
max_attempts=30
while ! php artisan migrate --force >/tmp/migrate.log 2>&1; do
  attempt=$((attempt + 1))
  if [ "$attempt" -ge "$max_attempts" ]; then
    cat /tmp/migrate.log
    exit 1
  fi
  echo "Waiting for database to be ready..."
  sleep 2
done

php artisan db:seed --force || true
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
