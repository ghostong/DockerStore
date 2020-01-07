#!/bin/bash

if [[ ! -e /etc/kapacitor/kapacitor.conf ]]; then
    cp -rf /tmp/dependence/kapacitor.conf /etc/kapacitor/kapacitor.conf
fi

exec $@