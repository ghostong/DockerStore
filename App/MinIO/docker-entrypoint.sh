#!/bin/bash
mkdir -p /volume/config/certs/
cp -r /etc/nginx/ssl/dockerstore.ssh2.cc.key /volume/config/certs/private.key
cp -r /etc/nginx/ssl/dockerstore.ssh2.cc.pem /volume/config/certs/public.crt
exec $@