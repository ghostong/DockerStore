#!/bin/bash
docker run -it --rm --name docker-store -v /var/run/docker.sock:/var/run/docker.sock -p 9000:9000 --name DockerStore docker-store:latest