#!/bin/bash

if [[ ! -e /workdir/conf.d/helloWorld.conf ]]; then
    cp -r /tmp/dependence/helloWorld.conf /workdir/conf.d/helloWorld.conf
fi

if [[ ! -e /workdir/nginx/conf/nginx.conf ]]; then
    cp -rf /usr/local/openresty/nginx/* /workdir/nginx
    cp -rf /tmp/dependence/nginx.conf /workdir/nginx/conf/nginx.conf
fi

exec "$@"