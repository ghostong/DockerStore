#!/bin/bash

if [[ ! -f "/root/.ssh/config" ]]; then
   cp /tmp/config /root/.ssh/config
   chmod 700 /root/.ssh
   chmod 600 /root/.ssh/config
fi

/etc/init.d/ssh start

exec "$@"
