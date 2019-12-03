#!/bin/bash
if [[ ! -e /volume/config/config.json ]]; then
    cp /tmp/dependence/config.json /volume/config/config.json
fi

exec "$@"