#!/bin/bash
if [[ ! -f "/workdir/config/config.php" ]];then
    touch /workdir/config/CAN_INSTALL
    chown www-data:www-data /workdir/apps
    chown www-data:www-data /workdir/data
    chown www-data:www-data /workdir/config
    chown
fi
/etc/init.d/php7.2-fpm start
nginx -g 'daemon off;'