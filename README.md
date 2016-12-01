REST API server-side tutorial. How to do it easy with Symfony 2.8.

```
#!sh

git clone https://bitbucket.org/onekit/rest-tutorial.git

cd rest-tutorial
```

## Docker way one command installation ##  
Download & Install: [https://docker.com](https://docker.com)  
Enter to project directory and run:  
```
#!sh
docker-compose up -d
```
Will create containeres: PHP, Nginx, MySQL.

For PostgreSQL database, type:
```
#!sh
docker-compose -f docker-compose-pgsql.yml up -d
```

## Manual ##

Get commands from https://getcomposer.org/download/
and execute:


```
#!sh

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
It will put *composer.phar* file in your project directory.  

Then install dependencies:


```
#!sh

php composer.phar install
```


Answer on questions after downloading. It will configure connections to database and let choose own parameters.  


```
#!sh

php app/console doctrine:database:create
php app/console doctrine:schema:create
php app/console assets:install web --symlink
php app/console assetic:dump
php app/console doctrine:fixtures:load --no-interaction
```



If you launch it locally, then can test fast with internal http-server.

```
#!sh

php app/console server:run localhost:8080

```

### P.S.: ###
Docker installation on video: https://www.youtube.com/watch?v=a3IFkmxmzFk
Manual installation on video: https://www.youtube.com/watch?v=nz1qudAh5hk