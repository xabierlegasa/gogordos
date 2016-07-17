<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Repositories\RestaurantRepository;
use PDO;

class RestaurantRepositoryMysql extends BaseRepository implements RestaurantRepository
{
    /**
     * Insert a restaurant in the DB. Returns true if successful, or false otherwise
     * @param Restaurant $restaurant
     * @return bool
     */
    public function save(Restaurant $restaurant)
    {
        $name = $restaurant->name();
        $city = $restaurant->city();
        $categoryId = $restaurant->category()->id();
        $createdAt = date('Y-m-d H:i:s');

        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('INSERT INTO restaurants (name, city, category_id, created_at) VALUES (?, ?, ?, ?)');
        $statement->bindParam(1, $name, PDO::PARAM_STR);
        $statement->bindParam(2, $city, PDO::PARAM_STR);
        $statement->bindParam(3, $categoryId, PDO::PARAM_INT);
        $statement->bindParam(4, $createdAt, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }
}
