<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Category;
use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Repositories\RestaurantRepository;
use PDO;
use PDOStatement;

class RestaurantRepositoryMysql extends BaseRepository implements RestaurantRepository
{
    /**
     * Insert a restaurant in the DB. Returns true if successful, or false otherwise
     * @param Restaurant $restaurant
     * @return bool
     * @throws \Exception
     */
    public function save(Restaurant $restaurant)
    {
        if ($restaurant->id() === null) {
            $name = $restaurant->name();
            $city = $restaurant->city();
            $categoryId = $restaurant->category()->id();
            $userId = $restaurant->userId();
            $createdAt = date('Y-m-d H:i:s');


            /** @var PDO $pdo */
            $pdo = $this->getConnection();
            /** @var PDOStatement $statement */
            $statement = $pdo->prepare('INSERT INTO restaurants (name, city, category_id, user_id, created_at) VALUES (?, ?, ?, ?, ?)');
            $statement->bindParam(1, $name, PDO::PARAM_STR);
            $statement->bindParam(2, $city, PDO::PARAM_STR);
            $statement->bindParam(3, $categoryId, PDO::PARAM_INT);
            $statement->bindParam(4, $userId, PDO::PARAM_STR);
            $statement->bindParam(5, $createdAt, PDO::PARAM_STR);

            $result = $statement->execute();

            if (!$result) {
                throw new \Exception('Error creating a new restaurant');
            }
            $restaurantId = (int)$pdo->lastInsertId();
            return new Restaurant(
                $restaurantId,
                $name,
                $city,
                $restaurant->category(),
                $userId,
                $createdAt
            );
        } else {
            throw new \Exception('implement update of a restaurant');
        }


        return $restaurant;
    }

    /**
     * @param User $user
     * @return Restaurant[]
     */
    public function findByUser(User $user)
    {
        $userId = $user->id()->value();

        /** @var PDO $pdo */
        $pdo = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $pdo->prepare(
            'SELECT r.user_id as user_id,
                r.id as restaurant_id, c.id as category_id,
                r.name as restaurant_name, r.city as restaurant_city,
                c.name as category_name, c.name_es as category_es,
                r.created_at as created_at
            FROM restaurants AS `r` 
              LEFT JOIN CATEGORIES AS `c` 
              ON r.category_id=c.id 
            WHERE user_id = :user_id');
        $statement->bindParam(1, $name, PDO::PARAM_STR);

        $statement->execute([
            ':user_id' => $userId
        ]);
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurants[] = new Restaurant(
                $row->restaurant_id,
                $row->restaurant_name,
                $row->restaurant_city,
                new Category((int)$row->category_id, $row->category_name, $row->category_es),
                $row->user_id,
                $row->created_at
            );
        }

        return $restaurants;
    }
}
