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
    cd /volume/
    /etc/init.d/zerotier-one start
    /etc/init.d/zerotier-one stop
    sleep 2
    zerotier-idtool initmoon /var/lib/zerotier-one/identity.public > moon.json
    sed -i 's/"stableEndpoints": \[\]/"stableEndpoints": ["${ZEROTIERMOON_SERVERIP}"]/g' moon.json
    zerotier-idtool genmoon moon.json
fi

exec "$@"