#!/bin/bash

if [[ ! -e /workdir/Config/config.json ]]; then
  cp /workdir/example.json /workdir/Config/config.json
fi

php Server.php

exec "$@"