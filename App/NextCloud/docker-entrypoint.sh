#!/bin/bash

cp -rf /tmp/dependence/fpm/* /etc/php/7.2/fpm

if [[ ! -f "/workdir/config/config.php" ]]; then
    unzip -o -d /workdir/ /tmp/dependence/nextcloud-17.0.1.zip && mv /workdir/nextcloud/* /workdir && rm -rf /workdir/nextcloud
    mkdir /workdir/data
    chown  -R www-data /workdir/config /workdir/data /workdir/apps
fi

if [[ ! -f "/etc/nginx/ssl/dockerstore.ssh2.cc.key" ]]; then
    cp -r /tmp/dependence/ssl/* /etc/nginx/ssl/
fi

cp -r /tmp/dependence/default /etc/nginx/sites-available/default

/etc/init.d/php7.2-fpm start

exec "$@"