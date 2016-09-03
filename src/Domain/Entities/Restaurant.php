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
     * @var User
     */
    private $user;

    /**
     * @var
     */
    private $createdAt;

    /**
     * @var
     */
    private $reason;
    /**
     * @var string
     */
    private $address;

    /**
     * Restaurant constructor.
     * @param int $id
     * @param string $name
     * @param string $city
     * @param string $address
     * @param Category $category
     * @param string $userId
     * @param string $reason
     * @param string $createdAt
     */
    public function __construct($id, $name, $city, $address, Category $category, $userId, $reason, $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->address = $address;
        $this->category = $category;
        $this->userId = $userId;
        $this->reason = $reason;
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

    /**
     * @return string
     */
    public function reason()
    {
        return $this->reason;
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
            'address' => $this->address(),
            'categoryId' => $this->category()->id(),
            'reason' => $this->reason(),
            'categoryName' => $this->category()->name(),
            'categoryNameEs' => $this->category()->nameEs()
        ];
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    public function address()
    {
        return $this->address;
    }
}
