#!/bin/bash
docker run -it --rm \
    -v /var/run/docker.sock:/var/run/docker.sock \
    -p 9000:9000 \
    --env USERNAME="ghost" \
    --env PASSWORD="123456" \
    --name DockerStore \
    docker-store:latest