#!/bin/bash
docker run -itd \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -p 9000:9000 \
    --env USERNAME="username" \
    --env PASSWORD="password" \
    --name DockerStore \
    registry.cn-hangzhou.aliyuncs.com/litosrc/decker-store:latest