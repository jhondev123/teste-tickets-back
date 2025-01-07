#!/bin/sh

composer install
touch /var/www/html/storage/logs/laravel.log
chmod -R 777 /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html
chmod -R 777 /var/www/html

chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

mkdir -p /var/www/html/storage/logs
chmod -R 777 /var/www/html/storage/logs
chown -R www-data:www-data /var/www/html/storage/logs

php artisan config:clear
php artisan cache:clear

mv .env.example .env

php artisan key:generate

php artisan migrate --seed --force

exec php-fpm
