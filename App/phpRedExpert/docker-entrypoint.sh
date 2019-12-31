#!/bin/bash

cp -f /tmp/dependence/apache2.conf /etc/apache2/apache2.conf

cp -f /tmp/dependence/000-default.conf /etc/apache2/sites-available/000-default.conf

if [[ ! -e /workdir/app/config/parameters.yml ]]; then
    cp -r /tmp/dependence/phpredexpert/* /workdir
fi

cp -f /tmp/dependence/parameters.yml /workdir/app/config/parameters.yml

chmod 660 /workdir/app/config/parameters.yml

chown www-data:www-data /workdir/* -R

cp /tmp/dependence/inotify.sh /

sh /inotify.sh &

if [[ ! -e /volume/config/htpasswd ]]; then
     htpasswd -bc /volume/config/htpasswd admin 123@456@
fi

exec "$@"