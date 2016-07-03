<?php

namespace Gogordos\Domain\Entities;


use Ramsey\Uuid\Uuid;

class UserId {

    /**
     * @var Uuid
     */
    private $value;

    /**
     * Create a new Uuid instance
     * @param Uuid $value
     */
    public function __construct(Uuid $value)
    {
        $this->value = $value;
    }

    /**
     * Create a UserId from a string
     *
     * @param string $userId
     * @return UserId
     */
    public static function fromString($userId)
    {
        return new UserId(Uuid::fromString($userId));
    }

    /**
     * Return the object as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value->toString();
    }

}