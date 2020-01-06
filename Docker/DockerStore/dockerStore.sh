#!/bin/bash

#Web端口 可直接加入IP, 进行IP访问限制, 例如 127.0.0.1:9100
PORT=9100
#用户名
USERNAME="dockerstore"
#密码
PASSWORD="dockerstore"

start () {
    docker run -itd \
    --restart always \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -v /tmp/DockerStore/:/tmp/DockerStore/ \
    -p ${3}:9100 \
    --env USERNAME=${1} \
    --env PASSWORD=${2} \
    --name DockerStore \
    registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest
    echo "Start"
}

stop () {
    docker rm -f DockerStore
    echo "Stop"
}

restart () {
    stop
    start ${1} ${2} ${3}
}

install () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php install
}

update () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php update
}

upgrade () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php upgrade
}

if [[ "start" == ${1} ]]; then
    start ${USERNAME} ${PASSWORD} ${PORT}
elif [[ "stop" == ${1} ]]; then
    stop
elif [[ "restart" == ${1} ]]; then
    restart ${USERNAME} ${PASSWORD} ${PORT}
elif [[ "install" == ${1} ]]; then
    install
elif [[ "update" == ${1} ]]; then
    update
elif [[ "upgrade" == ${1} ]]; then
    upgrade
else
    echo "none";
fi

