#!/bin/bash

chown mysql:mysql -R /var/lib/mysql
chown mysql:mysql -R /var/log/mysql

if [[ ! -d "/var/lib/mysql/mysql" ]]; then
  mysqld --initialize-insecure
fi

/etc/init.d/php7.2-fpm start
/etc/init.d/mysql start

exec "$@"