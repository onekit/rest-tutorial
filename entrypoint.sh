#!/usr/bin/env bash
php app/console doctrine:database:create --if-not-exists
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load --no-interaction
