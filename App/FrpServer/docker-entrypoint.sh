#!/bin/bash

if [[ ! -e /volume/config/frps.ini ]]; then
    cp /tmp/dependence/frps.ini /volume/config/frps.ini
fi

/etc/init.d/nginx start

exec "$@"
