#!/bin/sh
set -eu

if [ "${1:-}" != "apache2-foreground" ]; then
    exec "$@"
fi

: "${PORT:=80}"
: "${APP_ENV:=production}"
: "${APP_DEBUG:=false}"
: "${LOG_CHANNEL:=stderr}"
: "${LOG_LEVEL:=debug}"
: "${DB_CONNECTION:=mysql}"
: "${SESSION_DRIVER:=file}"
: "${CACHE_STORE:=file}"
: "${QUEUE_CONNECTION:=sync}"

if [ -z "${RUN_MIGRATIONS+x}" ]; then
    if [ "${RENDER:-}" = "true" ] || [ -n "${RAILWAY_SERVICE_ID:-}" ]; then
        RUN_MIGRATIONS=true
    else
        RUN_MIGRATIONS=false
    fi
fi

if [ -z "${RUN_SEEDERS+x}" ]; then
    RUN_SEEDERS="$RUN_MIGRATIONS"
fi

export PORT APP_ENV APP_DEBUG LOG_CHANNEL LOG_LEVEL DB_CONNECTION SESSION_DRIVER CACHE_STORE QUEUE_CONNECTION RUN_MIGRATIONS RUN_SEEDERS

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is required. Set APP_KEY in your deployment environment." >&2
    exit 1
fi

sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan storage:link --force || true

if [ "$RUN_MIGRATIONS" = "true" ]; then
    if [ "$RUN_SEEDERS" = "true" ]; then
        echo "Running Laravel migrations and seeders before Apache starts."
        php artisan migrate --force --seed
    else
        echo "Running Laravel migrations before Apache starts."
        php artisan migrate --force
    fi
elif [ "$RUN_SEEDERS" = "true" ]; then
    echo "Running Laravel seeders before Apache starts."
    php artisan db:seed --force
fi

php artisan optimize

exec "$@"
