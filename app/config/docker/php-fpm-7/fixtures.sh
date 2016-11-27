#!/bin/bash
while ! curl --output /dev/null --silent --head --fail http://172.25.0.1:3306; do sleep 1 && echo -n .; done;
cd /app
php app/console doctrine:database:create --if-not-exists
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load --no-interaction
