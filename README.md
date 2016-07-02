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
./vendor/bin/phpunit --coverage-clover "tests/reports/unit/coverage.xml" --log-junit "tests/reports/unit/log-junit-phpunit.xml" --coverage-html "tests/reports/unit/coverage-html/"
```

## Deploy

Deploy to prod:

```
cd ansistrano
ansible-playbook -i hosts_prod -e "ansistrano_release_version=`date -u +%Y%m%d%H%M%SZ`" deploy.ym
```







