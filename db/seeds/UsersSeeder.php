<?php

use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $password = password_hash('1111', PASSWORD_DEFAULT);
        
        /*  USERS ---------------------------------------------- */
        $faker = Faker\Factory::create();

        $userId = new UserId(Uuid::uuid4());
        $users[] = [
            'id' => $userId->value(),
            'email' => 'xabierlegasa@example.com',
            'username' => 'xabi',
            'password_hash' => $password,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => 'null'
        ];

        $userId = new UserId(Uuid::uuid4());
        $users[] = [
            'id' => $userId->value(),
            'email' => 'xabierlegasa+2@example.com',
            'username' => 'xabi2',
            'password_hash' => $password,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => 'null'
        ];

        // Dummy users
        for( $i = 0; $i < 100; $i++) {

            $email = $faker->email;
            $username = $faker->username;
            $userId = new UserId(Uuid::uuid4());

            $user = [
                'id' => $userId->value(),
                'email' => $email,
                'username' => $username,
                'password_hash' => $password, // psw: 1111
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => 'null'
            ];

            $users[] = $user;
        }

        $posts = $this->table('users');
            $posts->insert($users)
              ->save();




        /*  RESTAURANTS ---------------------------------------------- */

        $restaurants = [];
        foreach ($users as $user) {
            $numRestaurants = rand(0, 7);

            for ($i = 0; $i < $numRestaurants; $i++) {

                $categoryId = rand(1, 50);
                 $restaurant = [
                     'name' => $faker->firstname . ' Restaurant',
                     'city' => $faker->city,
                     'category_id' => $categoryId,
                     'user_id' => $user['id'],
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => 'null'

                 ];

                $restaurants[] = $restaurant;
            }
        }

        $posts = $this->table('restaurants');
        $posts->insert($restaurants)
            ->save();



        /*  FRIENDS---------------------------------------------- */

        $friends = [
            [
                'user_id_follower' => $users[0]['id'],
                'user_id_following' => $users[1]['id'],
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id_follower' => $users[1]['id'],
                'user_id_following' => $users[0]['id'],
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        foreach ($users as $user) {
            $followerId = $user['id'];
            $numFriends = rand(0, 7);

            for ($i = 0; $i < $numFriends; $i++) {

                $followingId = $users[rand(0, count($users) -1)]['id'];

                if (!$this->friendshipExist($friends, $followerId, $followingId)) {
                    $friends[] = [
                        'user_id_follower' => $followerId,
                        'user_id_following' => $followingId,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
        }


        $posts = $this->table('friends');
        $posts->insert($friends)
            ->save();



    }


    private function friendshipExist(array $friends, $idFollower, $idFollowing)
    {
        foreach($friends as $friend) {
            if ($friend['user_id_follower'] === $idFollower && $friend['user_id_following'] === $idFollowing) {
                return true;
            }
        }

        return false;
    }
}
