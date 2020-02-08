#!/bin/bash

cp /tmp/dependence/default /etc/nginx/sites-available/default

if [[ ! -f "/workdir/conf/users.auth.php" ]]; then
    tar zxvf /tmp/dependence/dokuwiki-stable.tgz -C /tmp/dependence/ && mv /tmp/dependence/dokuwiki-2018-04-22b/* /workdir/
    chown www-data:www-data /workdir/data -R
    chown www-data:www-data /workdir/conf -R
fi

/etc/init.d/php7.2-fpm start

exec "$@"