<?php

namespace Gogordos\Domain\Entities;

class Restaurant implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $city;
    /**
     * @var Category
     */
    private $category;

    /**
     * Restaurant constructor.
     * @param string $name
     * @param string $city
     * @param Category $category
     */
    public function __construct($name, $city, Category $category)
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
     * @return Category
     */
    public function category()
    {
        return $this->category;
    }

    public function jsonSerialize() {
        return [
            'name' => $this->name,
            'city' => $this->city,
            'category' => $this->category()->id()
        ];
    }
}
