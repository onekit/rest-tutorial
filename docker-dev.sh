docker-compose up -d
docker run resttutorial_php composer install --no-interaction --optimize-autoloader
docker run resttutorial_php php app/console doctrine:database:create --if-not-exists
docker run resttutorial_php php app/console doctrine:schema:update --force
docker run resttutorial_php php app/console doctrine:fixtures:load --no-interaction