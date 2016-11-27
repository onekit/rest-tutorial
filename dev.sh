#!/usr/bin/env bash
docker-compose down
docker rmi $(docker images -q)
#docker-compose up --build -d
docker-compose up -d db
docker-compose up -d

