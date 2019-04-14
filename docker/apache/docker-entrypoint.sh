#!/bin/bash
set -e
cp /.env /var/www
cd /var/www/ && php composer.phar config -g github-oauth.github.com key here
cd /var/www/ && php -d memory_limit=2024M composer.phar update
cd /var/www/ && php artisan config:clear;
cd /var/www/ && php artisan cache:clear;
/usr/sbin/httpd -D FOREGROUND "$@"
exec "$@"