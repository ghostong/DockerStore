#!/bin/bash
cp ./Docker/DockerStore/dockerfile .
docker build -t registry.cn-hangzhou.aliyuncs.com/litosrc/decker-store:docker-store:latest .
rm ./dockerfile
docker push registry.cn-hangzhou.aliyuncs.com/litosrc/decker-store:latest
