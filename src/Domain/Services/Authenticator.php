<?php

namespace Gogordos\Domain\Services;

use Gogordos\Domain\Entities\User;

interface Authenticator
{
    /**
     * @param User $user
     * @return string
     */
    public function authTokenFromUser(User $user);

    /**
     * @param string $token
     * @return AuthUserData
     * @throws \InvalidArgumentException
     */
    public function authUserDataFromToken($token);
}
