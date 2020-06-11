#!/bin/bash
cp -r /etc/nginx/ssl/dockerstore.ssh2.cc.key /volume/config/certs/private.key
cp -r /etc/nginx/ssl/dockerstore.ssh2.cc.pem /volume/config/certs/public.crt
exec $@