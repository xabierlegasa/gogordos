Todo list:

- Use a directive to create this snipet that is now duplicated: http://jsfiddle.net/gyF6V/1/

        <div>
            <div ng-repeat="res in restaurants">
                <p>
                    <a ui-sref="userPage({username: res.username})">{{res.username}}</a>
                    recomienda
                    <span class="bg-info lead">"{{res.name}}"</span>
                    en
                    <a ui-sref="cityRestaurants({city: res.city})">{{res.city}}</a>
                    , {{res.categoryNameEs}}.
                </p>
            </div>
        </div>




drop database gogordos;
CREATE DATABASE gogordos CHARACTER SET utf8 COLLATE utf8_general_ci;



Commands


./vendor/bin/phinx migrate
./vendor/bin/phinx create MyNewMigration
mysqldump gogordos -uroot -p > /Users/xabi/Documents/gogordos/dump_2016_07_24.sql


Urls

https://github.com/ruckus/ruckusing-migrations/wiki/Getting-Started
