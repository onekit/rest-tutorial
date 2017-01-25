REST API server-side tutorial. How to do it easy with Symfony 2.8.

```
#!sh

git clone https://bitbucket.org/onekit/rest-tutorial.git

cd rest-tutorial
```

## Docker way ##
[Docker install video](https://www.youtube.com/watch?v=a3IFkmxmzFk).  
Download & Install: [https://docker.com](https://docker.com)  
Enter to project directory and run: ```docker-compose up -d```  
It will create and launch three containeres: PHP, Nginx and MySQL.  
If you prefer PostgreSQL, type ```docker-compose -f docker-compose-pgsql.yml up -d``` instead of previous command.  

## Manual ##
[Manual install video](https://www.youtube.com/watch?v=nz1qudAh5hk).  
Get commands from https://getcomposer.org/download/
and execute.

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

License
-------

This code is under the MIT license. See the complete license in the bundle:

    app/Resources/meta/LICENSE