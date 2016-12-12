php app/console cache:clear --env=prod --no-debug
php app/console cache:clear --env=dev --no-debug
php app/console cache:clear --env=test --no-debug
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install web --symlink
php app/console assetic:dump
php app/console doctrine:fixtures:load --no-interaction

