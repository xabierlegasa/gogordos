<?php

namespace Gogordos\Application\UseCases\AddRestaurant;


use Gogordos\Domain\Entities\Restaurant;

class AddRestaurantResponse
{
    /**
     * @var Restaurant
     */
    private $restaurant;

    /**
     * AddRestaurantResponse constructor.
     * @param Restaurant $restaurant
     */
    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }
    
    public function restaurant()
    {
        return $this->restaurant;
    }
}
