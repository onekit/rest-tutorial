docker-compose up -d
docker exec resttutorial_php_1 php app/console doctrine:database:create --if-not-exists
docker exec resttutorial_php_1 php app/console doctrine:schema:update --force
docker exec resttutorial_php_1 php app/console doctrine:fixtures:load --no-interaction
echo "-------------------------"
echo "Now open http://localhost"
echo "-------------------------"
