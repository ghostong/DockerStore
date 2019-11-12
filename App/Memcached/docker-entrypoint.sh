#!/bin/bash
echo 123@456@ | saslpasswd2 -a memcached -c -p -f /etc/sasl2/memcached-sasldb2 memcached
chown memcache:memcache /etc/sasl2/memcached-sasldb2
memcached -m 64 -p 11211 -u memcache -l 0.0.0.0 -P /volume/run/memcached.pid -S