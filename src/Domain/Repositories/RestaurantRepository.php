<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;

interface RestaurantRepository
{
    /**
     * @param Restaurant $restaurant
     * @return bool
     */
    public function save(Restaurant $restaurant);

    /**
     * @param User $user
     * @return Restaurant[]
     */
    public function findByUser(User $user);
}