<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\Restaurant;

interface RestaurantRepository
{
    /**
     * @param Restaurant $restaurant
     * @return bool
     */
    public function save(Restaurant $restaurant);
}