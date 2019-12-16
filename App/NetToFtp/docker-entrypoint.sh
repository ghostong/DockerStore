#!/bin/bash

if [[ ! -f "/etc/nginx/sites-available/default" ]]; then
   cp /tmp/dependence/default /etc/nginx/sites-available/default
fi

if [[ ! -f "/etc/php/7.2/fpm/php.ini" ]]; then
    cp -rf /tmp/dependence/fpm/* /etc/php/7.2/fpm
    ln -s /etc/php/7.2/mods-available /etc/php/7.2/fpm/conf.d
fi

if [[ ! -f "/workdir/settings.inc.php" ]]; then
    unzip -d /tmp/ /tmp/dependence/net2ftp_v1.3.zip && mv /tmp/net2ftp_v1.3/files_to_upload/* /workdir
    chown www-data:www-data /workdir/temp/ -R
fi

/etc/init.d/php7.2-fpm start

exec "$@"