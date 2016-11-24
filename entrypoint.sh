#!/bin/bash

#immediatly exit if a command fails:
set -e

php /app/app/console --env=prod cache:clear

php /app/app/console --env=prod assets:install
php /app/app/console --env=prod assetic:dump

php /app/app/console doctrine:database:create --if-not-exists
php /app/app/console doctrine:schema:update --force
php /app/app/console doctrine:fixtures:load --no-interaction --env=prod
