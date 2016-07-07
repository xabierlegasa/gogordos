<?php

namespace Gogordos\Application\UseCases\Login;


use Gogordos\Domain\Entities\User;

class LoginResponse
{
    /**
     * @var User
     */
    private $user;

    /**
     * LoginResponse constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user()
    {
        return $this->user;
    }
}
