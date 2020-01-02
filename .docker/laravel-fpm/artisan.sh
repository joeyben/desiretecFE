#!/bin/bash

php /var/www/html/artisan storage:link
php /var/www/html/artisan migrate --force

php /var/www/html/artisan cache:clear
php /var/www/html/artisan config:clear

php /var/www/html/artisan config:cache
php /var/www/html/artisan view:cache


exit 0
