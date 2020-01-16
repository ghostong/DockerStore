#!/bin/bash

if [[ ! -f "/workdir/ssl/dockerstore.ssh2.cc.key" ]]; then
    cp -r /tmp/dependence/ssl /workdir/
fi

/etc/init.d/ssh start

exec "$@"
