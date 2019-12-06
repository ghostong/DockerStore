#!/bin/bash
cp ./Docker/DockerStore/dockerfile .
cp ./Docker/DockerStore/docker-compose.yml .
docker-compose build
rm ./dockerfile
rm ./docker-compose.yml
docker-compose push
