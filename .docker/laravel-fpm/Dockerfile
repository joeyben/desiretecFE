FROM horrorhorst/composer-prestissimo:latest as vendor

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY tests tests
COPY database database


RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --no-dev

FROM horrorhorst/laravel-fpm-base:latest
COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY .docker/laravel-fpm/docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
COPY .docker/laravel-fpm/artisan.sh /usr/local/bin/artisan-cmds
COPY .docker/laravel-fpm/supervisord.conf /etc/supervisord.conf
COPY .docker/laravel-fpm/supervisord.d /etc/supervisord.d
RUN chmod +x /usr/local/bin/docker-php-entrypoint && chmod +x /usr/local/bin/artisan-cmds

RUN mv /var/www/html/.docker/laravel-fpm/laravel.ini /usr/local/etc/php/conf.d
RUN mv /var/www/html/.docker/laravel-fpm/php.ini /usr/local/etc/php/php.ini
RUN mv /var/www/html/.docker/laravel-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
USER root

RUN composer dump-autoload -a --no-dev && \
    rm -r /var/www/html/.docker && \
    rm /var/www/html/docker-compose.* && \
    rm -r /var/www/html/.git
