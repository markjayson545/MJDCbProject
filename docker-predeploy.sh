#!/bin/sh
set -eu

: "${APP_ENV:=production}"
: "${APP_DEBUG:=false}"
: "${LOG_CHANNEL:=stderr}"
: "${LOG_LEVEL:=debug}"
: "${DB_CONNECTION:=mysql}"
: "${SESSION_DRIVER:=file}"
: "${CACHE_STORE:=file}"
: "${QUEUE_CONNECTION:=sync}"

export APP_ENV APP_DEBUG LOG_CHANNEL LOG_LEVEL DB_CONNECTION SESSION_DRIVER CACHE_STORE QUEUE_CONNECTION

php artisan migrate --force --seed
