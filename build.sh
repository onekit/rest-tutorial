#!/bin/sh
git pull
php app/console cache:clear --env=prod --no-debug
php app/console cache:clear --env=dev --no-debug
php app/console cache:clear --env=test --no-debug
php app/console doctrine:schema:update --force
php app/console asset:install
php app/console assetic:dump

chmod 777 app/cache -R
chmod 777 app/logs -R
chmod 777 app/media -R
chmod 777 web/media -R
chmod 755 build.sh
chmod 755 test.sh

php app/console security:check
