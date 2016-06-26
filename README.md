## Gogordos

Restaurant recommendation between friends.


## Install

You will need PHP 5.6+ and Composer.


```
git clone git@github.com:xabierlegasa/gogordos.git
cd gogordos
composer install
php -S localhost:8080 -t public/
```


Project should be here: http://localhost:8080



## Run tests

```
./vendor/bin/phpunit
```


Tests with coverage:

```
./vendor/bin/phpunit --coverage-clover "tests/coverage/coverage.xml" --coverage-xml "tests/coverage/coverage-xml/" --coverage-html "tests/coverage/coverage-html/"
```