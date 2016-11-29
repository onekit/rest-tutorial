#!/usr/bin/env bash
docker-compose up -d
docker exec rest_php sh -c "while ! curl --output /dev/null --silent --head --fail http://172.25.0.1:3306; do sleep 1 && echo -n .; done;"
docker exec rest_php sh -c "php /app/app/console doctrine:schema:update --force"
docker exec rest_php sh -c "php /app/app/console doctrine:fixtures:load --no-interaction"
