#!/bin/bash
set -e
cp /.env /var/www
cd /var/www/ && php composer.phar config -g github-oauth.github.com githubkey
cd /var/www/ && php -d memory_limit=2024M composer.phar update
cd /var/www/ && php artisan config:clear;
cd /var/www/ && php artisan cache:clear;
cd /var/www/ && php artisan config:cache;
/usr/sbin/httpd -D FOREGROUND "$@"
exec "$@"