#!/bin/bash

cp -r /tmp/dependence/frpc /workdir
cp /tmp/dependence/frpc_example.ini /volume/config/frpc_example.ini


if [[ ! -e /volume/config/frpc.ini ]]; then
    cp /tmp/dependence/frpc.ini /volume/config/frpc.ini
fi

exec "$@"