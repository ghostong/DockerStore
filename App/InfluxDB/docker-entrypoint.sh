#!/bin/bash

if [[ ! -e /etc/influxdb/influxdb.conf ]]; then
    cp -rf  /tmp/dependence/influxdb.conf /etc/influxdb/influxdb.conf
fi
exec $@