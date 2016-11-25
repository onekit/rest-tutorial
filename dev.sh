docker-compose up -d
docker exec resttutorial_db_1 echo "bind-address = 0.0.0.0" > /etc/mysql/conf.d/mysql.cnf
docker restart resttutorial_db_1
docker exec resttutorial_php_1 php app/console doctrine:database:create --if-not-exists
docker exec resttutorial_php_1 php app/console doctrine:schema:update --force
docker exec resttutorial_php_1 php app/console doctrine:fixtures:load --no-interaction