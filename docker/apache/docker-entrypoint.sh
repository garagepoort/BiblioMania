#!/bin/bash
set -e
php /var/www/artisan config:clear;
php /var/www/artisan config:cache;
/usr/sbin/httpd -D FOREGROUND "$@"
exec "$@"
