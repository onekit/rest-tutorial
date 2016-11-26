#!/usr/bin/env bash
chown www-data:www-data -R /app /tmp
php app/console doctrine:database:create --if-not-exists
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load --no-interaction