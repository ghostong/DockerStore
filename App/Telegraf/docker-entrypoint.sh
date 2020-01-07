#!/bin/bash

if [[ ! -e /etc/telegraf/telegraf.conf ]]; then
    cp -rf /tmp/dependence/telegraf.conf /etc/telegraf/telegraf.conf
fi

exec $@