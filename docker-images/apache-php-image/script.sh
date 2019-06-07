#!/bin/bash
# Kill all containers and apache_php image
docker kill $(docker ps -q)
docker rm $(docker ps -a -q)
docker rmi res/apache_php

# Build the Docker image locally
docker build -t res/apache_php .

docker run -d -p 9090:80 res/apache_php
