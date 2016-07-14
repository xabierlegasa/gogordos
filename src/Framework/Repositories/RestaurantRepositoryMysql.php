<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Repositories\RestaurantRepository;

class RestaurantRepositoryMysql extends BaseRepository implements RestaurantRepository
{
    /**
     * Insert a restaurant in the DB. Returns true if successful, or false otherwise
     * @param Restaurant $restaurant
     * @return bool
     */
    public function save(Restaurant $restaurant)
    {
        $restaurantId = $restaurant->id();
        $name = $restaurant->name();
        $city = $restaurant->city();
        $category = $restaurant->category()->name();
        $createdAt = date('Y-m-d H:i:s');

        /** @var PDOStatement $statement */
        $statement = $this->getConnection()->prepare('INSERT INTO categories (id, name, city, category_id, created_at) VALUES (?, ?, ?, ?, ?)');
        $statement->bindParam(1, $restaurantId, PDO::PARAM_STR);
        $statement->bindParam(2, $name, PDO::PARAM_STR);
        $statement->bindParam(3, $city, PDO::PARAM_STR);
        $statement->bindParam(4, $category, PDO::PARAM_STR);
        $statement->bindParam(5, $createdAt, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }
}
