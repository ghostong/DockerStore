#!/bin/bash

if [[ ! -f "/workdir/ssl/webssh.crt" ]]; then
    cp -r /tmp/dependence/ssl /workdir/ssl
fi

/etc/init.d/ssh start

exec "$@"
