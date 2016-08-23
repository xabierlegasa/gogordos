Todo-s:

- Add address field to restaurants.
- Let edit a restaurant.
- Let "trust" a user. This user is trusted by X gogordos.
- Feature: show map with nearby gogordo places (show all by now)
- Features 2nd degree places: my following + their following.
- Create a backend. Show restaurants. Show restaurants without address to be able to add it manually.

drop database gogordos;
CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci;


Commands


./vendor/bin/phinx create AddAddressToRestaurant
./vendor/bin/phinx migrate
mysqldump gogordos -uroot -p > /Users/xabi/Documents/gogordos/dump_2016_07_24.sql
