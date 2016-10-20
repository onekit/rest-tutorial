rmdir "app/cache/test" /s /q
php app/console doctrine:database:drop --force --env=test
php app/console doctrine:database:create --env=test
php app/console doctrine:schema:create --env=test
php app/console assets:install web --symlink --env=test
php app/console assetic:dump --env=test
php app/console doctrine:fixtures:load --no-interaction --env=test
bin\behat.bat