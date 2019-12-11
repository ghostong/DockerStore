#!/bin/bash
cp ./Docker/DockerStore/dockerfile .
cp ./Docker/DockerStore/docker-compose.yml .
docker-compose build
rm ./dockerfile
docker-compose push
rm ./docker-compose.yml