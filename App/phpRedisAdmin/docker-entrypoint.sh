#!/bin/bash

if [[ ! -e /workdir/includes/config.sample.inc.php ]]; then
    cp -r /tmp/dependence/phpRedisAdmin/* /workdir
fi

if [[ ! -e /workdir/includes/config.inc.php ]]; then
    cp /workdir/includes/config.sample.inc.php /workdir/includes/config.inc.php
fi

/etc/init.d/php7.2-fpm start

exec "$@"