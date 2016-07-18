<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Category;
use Gogordos\Domain\Entities\Restaurant;
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
            $restaurantId = (int) $pdo->lastInsertId();
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

    public function findByUserId($userId)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $pdo->prepare('SELECT *  FROM restaurants WHERE ');
        $statement->bindParam(1, $name, PDO::PARAM_STR);



    }
}
