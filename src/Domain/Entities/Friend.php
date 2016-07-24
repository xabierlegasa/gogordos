<?php

namespace Gogordos\Domain\Entities;


class Friend
{
    /**
     * @var UserId
     */
    private $userIdFollower;
    /**
     * @var UserId
     */
    private $userIdFollowing;

    /**
     * Friend constructor.
     * @param UserId $userIdFollower
     * @param UserId $userIdFollowing
     */
    public function __construct(UserId $userIdFollower, UserId $userIdFollowing)
    {
        $this->userIdFollower = $userIdFollower;
        $this->userIdFollowing = $userIdFollowing;
    }

    public function userIdFollower()
    {
        return $this->userIdFollower;
    }

    public function userIdFollowing()
    {
        return $this->userIdFollowing;
    }
}
