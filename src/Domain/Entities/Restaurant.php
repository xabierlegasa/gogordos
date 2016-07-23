<?php

namespace Gogordos\Domain\Entities;

class Restaurant implements \JsonSerializable
{
    /** @var int */
    private $id;

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

    /** @var string */
    private $userId;

    /**
     * @var
     */
    private $createdAt;

    /**
     * Restaurant constructor.
     * @param int $id
     * @param string $name
     * @param string $city
     * @param Category $category
     * @param string $userId
     * @param string $createdAt
     */
    public function __construct($id, $name, $city, Category $category, $userId, $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->category = $category;
        $this->userId = $userId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
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

    public function userId()
    {
        return $this->userId;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => ucfirst($this->city),
            'categoryId' => $this->category()->id(),
            'categoryName' => $this->category()->name(),
            'categoryNameEs' => $this->category()->nameEs()
        ];
    }
}
