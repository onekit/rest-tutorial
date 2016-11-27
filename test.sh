#!/usr/bin/env bash
php app/console cache:clear --env=test --no-debug
php app/console doctrine:database:drop --force --env=test
php app/console doctrine:database:create --env=test
php app/console doctrine:schema:create --env=test
php app/console assets:install web --symlink --env=test
php app/console assetic:dump --env=test
php app/console doctrine:fixtures:load --no-interaction --env=test
chmod 777 app/cache -R
chmod 777 app/logs -R
chmod 777 app/media -R
chmod 777 web/media -R
bin/behat