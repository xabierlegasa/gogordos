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

    /** @var string */
    private $jwt;

    /** @var string */
    private $reason;

    /**
     * AddRestaurantRequest constructor.
     * @param $name
     * @param $city
     * @param $category
     * @param $reason
     * @param $jwt
     */
    public function __construct($name, $city, $category, $reason, $jwt)
    {
        $this->name = $name;
        $this->city = $city;
        $this->category = $category;
        $this->reason = $reason;
        $this->jwt = $jwt;
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

    public function jwt()
    {
        return $this->jwt;
    }

    public function reason()
    {
        return $this->reason;
    }
}
