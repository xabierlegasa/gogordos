#!/bin/bash


MYSQL_USER="root"
MYSQL_PASS="root"

cd /var/www/gogordos;

mysql -u "$MYSQL_USER" -p$MYSQL_PASS -e "drop database gogordos"
mysql -u "$MYSQL_USER" -p$MYSQL_PASS -e "CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci"

vendor/bin/phinx migrate -e development
vendor/bin/phinx seed:run
