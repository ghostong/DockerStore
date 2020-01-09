#!/bin/bash

cp -rf /tmp/dependence/coredns /workdir/coredns

if [[ ! -f "/workdir/config/Corefile" ]]; then
    cp -r /tmp/dependence/Corefile /workdir/config/Corefile
fi

if [[ ! -f "/workdir/config/own.host" ]]; then
    cp -r /tmp/dependence/own.host /workdir/config/own.host
fi

exec "$@"