#!/usr/bin/env bash
docker-compose up -d
docker exec rest_php chown www-data:www-data -R /tmp
echo "Please wait while MySQL first launch..."
sleep 5m #Wait for MySQL run & start listen connections
#echo "Trying to create database"
#docker exec rest_php php app/console doctrine:database:create --if-not-exists
#echo "Trying to create schema"
#docker exec rest_php php app/console doctrine:schema:update --force
#echo "Trying to load fixtures"
#docker exec rest_php php app/console doctrine:fixtures:load --no-interaction
echo "-------------------------"
echo "Now open http://localhost"
echo "-------------------------"
