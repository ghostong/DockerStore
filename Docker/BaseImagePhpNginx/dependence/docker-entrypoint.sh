#!/bin/bash

if [[ ! -f "/etc/nginx/sites-available/default" ]]; then
   cp /tmp/dependence/default /etc/nginx/sites-available/default
fi

if [[ ! -f "/etc/php/7.2/fpm/php.ini" ]]; then
    cp -rf /tmp/dependence/fpm/* /etc/php/7.2/fpm
    ln -s /etc/php/7.2/mods-available /etc/php/7.2/fpm/conf.d
fi

/etc/init.d/php7.2-fpm start

nginx -g 'daemon off;'