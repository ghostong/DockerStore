#!/bin/bash

if [[ ! -e /etc/nginx/sites-available/default ]]; then
   cp /tmp/dependence/default /etc/nginx/sites-available/default
fi

if [[ ! -e /volume/config/htpasswd ]]; then
     htpasswd -bc /volume/config/htpasswd admin 123@456@
fi

if [[ ! -e /volume/config/aria2.conf ]]; then
    cp /tmp/dependence/aria2.conf /volume/config/aria2.conf
fi

if [[ ! -e /volume/config/aria2.session ]]; then
    touch /volume/config/aria2.session
fi

cp -r /tmp/dependence/yaaw/* /workdir

/etc/init.d/nginx start

exec "$@"