<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;

interface RestaurantRepository
{
    /**
     * @param Restaurant $restaurant
     * @return bool
     */
    public function save(Restaurant $restaurant);

    /**
     * @param string $userId
     * @return Restaurant[]
     */
    public function findByUserId($userId);

    /**
     * @param User $user
     * @return Restaurant[]
     */
    public function findByUser(User $user);

    /**
     * @param int $offset
     * @param int $limit
     * @return Restaurant[]
     */
    public function findAllPaginated($offset, $limit);

    /**
     * @return int
     */
    public function countAll();

    /**
     * @param UserId $userId
     * @param int $offset
     * @param int $limit
     * @return \Gogordos\Domain\Entities\Restaurant[]
     */
    public function findByUserFriends(UserId $userId, $offset, $limit);


    /**
     * @param UserId $userId
     * @return int
     */
    public function findByUserFriendsTotal(UserId $userId);

    /**
     * @param $city
     * @param $offset
     * @param $limit
     * @return Restaurant[]
     */
    public function findByCityPaginated($city, $offset, $limit);

    /**
     * @param $city
     * @return int
     */
    public function countAllByCity($city);

    /**
     * @param string $userId
     * @return int
     */
    public function countByUserId($userId);
}
