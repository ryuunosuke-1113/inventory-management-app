#!/bin/sh

cd /var/www/src

cp .env.example .env
mkdir -p database
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 database

php artisan config:clear
php artisan route:clear
php artisan view:clear

touch database/database.sqlite

php artisan migrate --seed --force

php-fpm -D
nginx -g "daemon off;"