#!/bin/bash

if [[ ! -f "/workdir/config/CAN_INSTALL" ]]; then
    unzip -qo -d /workdir/ /tmp/dependence/nextcloud-17.0.1.zip && mv /workdir/nextcloud/* /workdir && rm -rf /workdir/nextcloud
    mkdir /workdir/data
    chown  -R www-data /workdir/config /workdir/data /workdir/apps
    echo 1;
fi

if [[ ! -f "/etc/nginx/ssl/nexccloud.crt" ]]; then
    cp -r /tmp/dependence/ssl/* /etc/nginx/ssl/
    echo 2;
fi

cp -r /tmp/dependence/default /etc/nginx/sites-available/default

/etc/init.d/php7.2-fpm start

nginx -g 'daemon off;'