#!/bin/bash
## !!!!请不要修改此文件!!!! ##

#导入配置文件
if [[ -e ./.dockerStoreConf ]]; then
    source ./.dockerStoreConf
fi

#配置默认值
if [[ ! ${PORT} ]];then
    PORT="9100"
fi
if [[ ! ${USERNAME} ]];then
    USERNAME="dockerstore"
fi
if [[ ! ${PASSWORD} ]];then
    PASSWORD="dockerstore"
fi

start () {
    docker run -itd \
    --restart always \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -v /tmp/DockerStore/:/tmp/DockerStore/ \
    -v /Volumes/DockerStore/DockerStore/SSL/:/Volumes/DockerStore/DockerStore/SSL/ \
    -v /Volumes/DockerStore/DockerStore/Env/:/Volumes/DockerStore/DockerStore/Env/ \
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

other () {
    docker run -it --rm -v /var/run/docker.sock:/var/run/docker.sock registry.cn-hangzhou.aliyuncs.com/litosrc/docker-store:latest php Server.php $1 $2
}

if [[ "start" == ${1} ]]; then
    start ${USERNAME} ${PASSWORD} ${PORT}
elif [[ "stop" == ${1} ]]; then
    stop
elif [[ "restart" == ${1} ]]; then
    restart ${USERNAME} ${PASSWORD} ${PORT}
else
    other ${1} ${2}
fi