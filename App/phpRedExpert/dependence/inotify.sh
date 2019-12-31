#/bin/sh

while true
do
    inotifywait -e modify,delete,create /workdir/app/config/parameters.yml
    sudo -u www-data php /workdir/app/console cache:clear --env=prod --no-debug
done