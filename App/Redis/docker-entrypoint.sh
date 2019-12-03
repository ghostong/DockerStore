#!/bin/bash
if [[ ! -e /volume/config/redis.conf ]]; then
    cp /etc/redis.conf /volume/config/redis.conf
fi

exec "$@"