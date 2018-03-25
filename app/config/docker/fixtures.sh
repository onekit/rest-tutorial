#!/usr/bin/env bash
php /app/app/console doctrine:schema:update --force
php /app/app/console doctrine:fixtures:load --no-interaction
chown www-data:www-data -R /app /tmp
