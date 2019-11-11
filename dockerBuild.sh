#!/bin/bash
cp ./Docker/DockerStore/dockerfile .
docker build -t docker-store:latest .
rm ./dockerfile
