#!/bin/bash
# Kill all containers and apache_php image
docker kill $(docker ps -q)
docker rm $(docker ps -a -q)
docker rmi res/express_students

# Build the Docker image locally
docker build -t res/express_students .

clear

docker run -p 9090:3000 res/express_students
