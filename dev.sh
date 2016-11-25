docker-compose down
docker-compose up -d
./wait-for-it.sh localhost:3306 --strict -t 120
docker exec rest_php php app/console doctrine:database:create --if-not-exists
docker exec rest_php php app/console doctrine:schema:update --force
docker exec rest_php php app/console doctrine:fixtures:load --no-interaction
echo "-------------------------"
echo "Now open http://localhost"
echo "-------------------------"
