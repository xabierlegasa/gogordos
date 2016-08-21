## Gogordos

Restaurant recommendations between friends.


## Install

You will need PHP 7.0+ and Composer.


```
cd /var/www
git clone git@github.com:xabierlegasa/gogordos.git
cd gogordos
composer install
```

## Run the server

From project root folder:

```
php -S localhost:8080 -t public/
```

The site should be available here: http://localhost:8080


## Database

Enter mysql and create the database:

```
CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci;
```


Copy configuration file and setup DB info:

```
cp src/Frameworks/Slim/config_env.php.dist src/Frameworks/Slim/config_env.php
```


Create the phinx config file and fill it in:

```
cp phinx.yml.dist phinx.yml
```

And now run the migrations:

```
./vendor/bin/phinx migrate
```


## Run tests

```
./vendor/bin/phpunit
```


Tests with coverage:

```
./vendor/bin/phpunit --coverage-clover "tests/reports/unit/coverage.xml" --log-junit "tests/reports/unit/log-junit-phpunit.xml" --coverage-html "tests/reports/unit/coverage-html/"
```

## Deploy

Deploy to prod:

```
ansible-playbook -i ./ansistrano/hosts_prod -e "ansistrano_release_version=`date -u +%Y%m%d%H%M%SZ`" ./ansistrano/deploy.yml
```






