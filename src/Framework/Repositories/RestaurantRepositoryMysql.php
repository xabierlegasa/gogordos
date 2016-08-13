<?php

namespace Gogordos\Framework\Repositories;

use Gogordos\Domain\Entities\Category;
use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\RestaurantRepository;
use PDO;
use PDOStatement;
use Ramsey\Uuid\Uuid;

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
            "select r.user_id,
            r.id as restaurant_id, c.id as category_id,
            r.name as restaurant_name, r.city as restaurant_city,
            c.name as category_name, c.name_es as category_es,
            r.created_at as created_at,
            u.id as user_id, u.email as user_email, u.username as user_username
            from restaurants as `r`
            left join categories as `c`
            on r.category_id=c.id
            left join users as `u`
            on r.user_id=u.id
            WHERE user_id = :user_id
            "
        );
        $statement->execute([
            ':user_id' => $userId
        ]);
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurant = new Restaurant(
                $row->restaurant_id,
                $row->restaurant_name,
                $row->restaurant_city,
                new Category((int)$row->category_id, $row->category_name, $row->category_es),
                $row->user_id,
                $row->created_at
            );

            $user = User::register(
                new UserId(Uuid::fromString($row->user_id)),
                $row->user_email,
                $row->user_username,
                null
            );
            $restaurant->setUser($user);

            $restaurants[] = $restaurant;
        }

        return $restaurants;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Restaurant[]
     */
    public function findAllPaginated($offset, $limit)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $pdo->prepare(
            "select r.user_id,
            r.id as restaurant_id, c.id as category_id,
            r.name as restaurant_name, r.city as restaurant_city,
            c.name as category_name, c.name_es as category_es,
            r.created_at as created_at,
            u.id as user_id, u.email as user_email, u.username as user_username
            from restaurants as `r`
            left join categories as `c`
            on r.category_id=c.id
            left join users as `u`
            on r.user_id=u.id
            limit :limit
            OFFSET :offset"
        );

        $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
        $statement->bindValue(":offset", $offset, PDO::PARAM_INT);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurant = new Restaurant(
                $row->restaurant_id,
                $row->restaurant_name,
                $row->restaurant_city,
                new Category((int)$row->category_id, $row->category_name, $row->category_es),
                $row->user_id,
                $row->created_at
            );
            $user = User::register(new UserId(Uuid::fromString($row->user_id)), $row->user_email, $row->user_username,
                null);
            $restaurant->setUser($user);
            $restaurants[] = $restaurant;
        }

        return $restaurants;
    }

    /**
     * Returns the total number of rows on the table
     * @return int
     */
    public function countAll()
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $sql = "SELECT count(*) FROM `restaurants`";
        $result = $pdo->prepare($sql);
        $result->execute();
        $numberOfRows = (int)$result->fetchColumn();

        return $numberOfRows;
    }

    /**
     * @param UserId $userId
     * @param int $offset
     * @param int $limit
     * @return \Gogordos\Domain\Entities\Restaurant[]
     */
    public function findByUserFriends(UserId $userId, $offset, $limit)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $statement = $pdo->prepare(
            "select f.user_id_following as user_id, u.username as user_username, r.id as restaurant_id, r.name as restaurant_name,
    r.city as restaurant_city, c.id as category_id, c.name as category_name,
    c.name_es as category_name_es
    from friends as `f`
	left join restaurants as `r`
	on f.user_id_following=r.user_id
	left join categories as `c`
	on c.id=r.category_id
	left join users as `u`
	on u.id=f.user_id_following
	where f.user_id_follower= :user_id
	and r.id is not null
	limit :limit
    OFFSET :offset"
        );

        $statement->bindValue(":user_id", $userId->value(), PDO::PARAM_INT);
        $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
        $statement->bindValue(":offset", $offset, PDO::PARAM_INT);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurant = new Restaurant(
                $row->restaurant_id,
                $row->restaurant_name,
                $row->restaurant_city,
                new Category((int)$row->category_id, $row->category_name, $row->category_name_es),
                $row->user_id,
                null
            );
            $user = User::register(new UserId(Uuid::fromString($row->user_id)), null, $row->user_username,
                null);
            $restaurant->setUser($user);
            $restaurants[] = $restaurant;
        }

        return $restaurants;
    }

    public function findByUserFriendsTotal(UserId $userId)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $statement = $pdo->prepare(
            "select count(r.id) as total
	from friends as `f`
	left join restaurants as `r`
	on f.user_id_following=r.user_id
	left join categories as `c`
	on c.id=r.category_id
	left join users as `u`
	on u.id=f.user_id_following
	where f.user_id_follower= :user_id
	and r.id is not null"
        );

        $statement->bindValue(":user_id", $userId->value(), PDO::PARAM_INT);

        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_OBJ);

        return (int)$rows->total;
    }

    /**
     * @param $city
     * @param $offset
     * @param $limit
     * @return Restaurant[]
     */
    public function findByCityPaginated($city, $offset, $limit)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();
        /** @var PDOStatement $statement */
        $statement = $pdo->prepare(
            "select r.user_id,
            r.id as restaurant_id, c.id as category_id,
            r.name as restaurant_name, r.city as restaurant_city,
            c.name as category_name, c.name_es as category_es,
            r.created_at as created_at,
            u.id as user_id, u.email as user_email, u.username as user_username
            from restaurants as `r`
            left join categories as `c`
            on r.category_id=c.id
            left join users as `u`
            on r.user_id=u.id
            where r.city = :city
            limit :limit
            OFFSET :offset"
        );

        $statement->bindValue(":city", $city, PDO::PARAM_STR);
        $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
        $statement->bindValue(":offset", $offset, PDO::PARAM_INT);

        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_OBJ);

        $restaurants = [];
        foreach ($rows as $row) {
            $restaurant = new Restaurant(
                $row->restaurant_id,
                $row->restaurant_name,
                $row->restaurant_city,
                new Category((int)$row->category_id, $row->category_name, $row->category_es),
                $row->user_id,
                $row->created_at
            );
            $user = User::register(new UserId(Uuid::fromString($row->user_id)), $row->user_email, $row->user_username,
                null);
            $restaurant->setUser($user);
            $restaurants[] = $restaurant;
        }

        return $restaurants;
    }

    /**
     * @param $city
     * @return int
     */
    public function countAllByCity($city)
    {
        /** @var PDO $pdo */
        $pdo = $this->getConnection();

        $sql = "SELECT count(*) FROM `restaurants` where city = :city";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(":city", $city, PDO::PARAM_STR);

        $statement->execute();
        $numberOfRows = (int)$statement->fetchColumn();

        return $numberOfRows;
    }
}
