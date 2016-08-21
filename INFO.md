Todo-s:
- Let "trust" a user. This user is trusted by X gogordos.
- Add address field to restaurants.
- Feature: show map with nearby gogordo places (show all by now)
- Create a backend. Show restaurants. Show restaurants without address to be able to add it manually.
- Features 2nd degree places: my following + their following.

drop database gogordos;
CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci;


Commands

./vendor/bin/phinx migrate
./vendor/bin/phinx create MyNewMigration
mysqldump gogordos -uroot -p > /Users/xabi/Documents/gogordos/dump_2016_07_24.sql
