docker-compose down
docker-compose up -d
docker exec rest_php ./wait-for-it.sh 172.25.0.1:3306 --strict
docker exec rest_php php app/console doctrine:database:create --if-not-exists
docker exec rest_php php app/console doctrine:schema:update --force
docker exec rest_php php app/console doctrine:fixtures:load --no-interaction
echo "-------------------------"
echo "Now open http://localhost"
echo "-------------------------"
