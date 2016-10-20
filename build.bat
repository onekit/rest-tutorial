rmdir "app/cache/prod" /s /q
rmdir "app/cache/dev" /s /q
rmdir "app/cache/staging" /s /q
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install web --symlink
php app/console assetic:dump
php app/console doctrine:fixtures:load --no-interaction
php app/console security:check

