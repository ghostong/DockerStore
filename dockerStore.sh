#!/bin/bash

#Web端口 可直接加入IP, 进行IP访问限制, 例如 127.0.0.1:9100
PORT=9100
#用户名
USERNAME="dockerstore"
#密码
PASSWORD="dockerstore"

start () {
    docker run -itd \
    -v /var/run/docker.sock:/var/run/docker.sock \
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

install () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php install
}

update () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php update
}

if [[ "start" == ${1} ]]; then
    start ${USERNAME} ${PASSWORD} ${PORT}
elif [[ "stop" == ${1} ]]; then
    stop
elif [[ "install" == ${1} ]]; then
    install
elif [[ "update" == ${1} ]]; then
    update
else
    echo "";
fi