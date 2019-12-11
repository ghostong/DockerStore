#!/bin/bash

cp -r /tmp/dependence/frpc /workdir
cp /tmp/dependence/frpc_example.ini /volume/config/frpc_example.ini

cp -r /tmp/dependence/frps /workdir
cp /tmp/dependence/frps.ini /workdir/frps.ini

if [[ ! -e /volume/config/frpc.ini ]]; then
    cp /tmp/dependence/frpc.ini /volume/config/frpc.ini
fi

./frps -c /workdir/frps.ini &

exec "$@"