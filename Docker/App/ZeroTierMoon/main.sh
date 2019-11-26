#!/bin/sh

export PATH=/bin:/usr/bin:/usr/local/bin:/sbin:/usr/sbin

if [ ! ${ZEROTIERMOON_SERVERIP} ]; then
    echo 'ZEROTIERMOON_SERVERIP not found';
    exit 1
fi

if [ ! -e /dev/net/tun ]; then
	echo 'FATAL: cannot start ZeroTier One in container: /dev/net/tun not present.'
	exit 1
fi

if [ ! -e /volume/config/moon.json ]; then
    cd /volume/config
    nohup zerotier-one >/dev/null 2>&1 &
    sleep 2
    zerotier-idtool initmoon /var/lib/zerotier-one/identity.public > moon.json
    sed -i 's/"stableEndpoints": \[\]/"stableEndpoints": ["${ZEROTIERMOON_SERVERIP}"]/g' moon.json
    zerotier-idtool genmoon moon.json
    kill -9 `cat /var/lib/zerotier-one/zerotier-one.pid`
fi

mv *.moon /var/lib/zerotier-one/moons.d/

exec "$@"