cd /app && php app/console doctrine:database:create --if-not-exists
cd /app && php app/console doctrine:schema:update --force
cd /app && php app/console doctrine:fixtures:load --no-interaction
