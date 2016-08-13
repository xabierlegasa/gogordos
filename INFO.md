Todo-s:
-Show my friends list



drop database gogordos;
CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci;


Commands

./vendor/bin/phinx migrate
./vendor/bin/phinx create MyNewMigration
mysqldump gogordos -uroot -p > /Users/xabi/Documents/gogordos/dump_2016_07_24.sql
