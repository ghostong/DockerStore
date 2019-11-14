#!/bin/bash
cp ./Docker/DockerStore/dockerfile .
docker-compose build
rm ./dockerfile
docker-compose push
