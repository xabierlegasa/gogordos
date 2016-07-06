<?php

namespace Gogordos\Domain\Entities;

class AuthUserData
{
    /**
     * @var UserId
     */
    private $userId;

    /** @var string */
    private $username;

    /**
     * AuthData constructor.
     * @param UserId $userId
     * @param $username
     */
    public function __construct(UserId $userId, $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId();
    }

    public function username()
    {
        return $this->username;
    }
}
