#!/bin/sh
set -eu

if [ "${1:-}" != "apache2-foreground" ]; then
    exec "$@"
fi

: "${PORT:=80}"
: "${APP_ENV:=production}"
: "${APP_DEBUG:=false}"
: "${LOG_CHANNEL:=stderr}"
: "${DB_CONNECTION:=mysql}"
: "${SESSION_DRIVER:=file}"
: "${CACHE_STORE:=file}"
: "${QUEUE_CONNECTION:=sync}"
: "${RUN_MIGRATIONS:=false}"

export PORT APP_ENV APP_DEBUG LOG_CHANNEL DB_CONNECTION SESSION_DRIVER CACHE_STORE QUEUE_CONNECTION RUN_MIGRATIONS

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is required. Set APP_KEY in your Render, Railway, or Docker environment." >&2
    exit 1
fi

sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan storage:link --force || true
php artisan optimize

if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force
fi

exec "$@"
