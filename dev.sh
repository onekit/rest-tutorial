#!/usr/bin/env bash
docker-compose up -d
docker exec rest_php php /app/app/console doctrine:schema:update --force
docker exec rest_php php /app/app/console doctrine:fixtures:load --no-interaction
