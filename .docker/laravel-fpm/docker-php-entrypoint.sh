#!/bin/sh
set -e

#/usr/bin/supervisord -n -c /etc/supervisord.conf &
/usr/local/bin/artisan-cmds

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
