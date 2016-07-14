<?php

namespace Gogordos\Application\UseCases\AddRestaurant;


class AddRestaurantRequest
{
    /**
     * @var string
     */
    private $name;
    
    /** @var string */
    private $city;
    
    /** @var string */
    private $category;

    /**
     * AddRestaurantRequest constructor.
     * @param $name
     * @param $city
     * @param $category
     */
    public function __construct($name, $city, $category)
    {
        $this->name = $name;
        $this->city = $city;
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function city()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function category()
    {
        return $this->category;
    }
}
