<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\User;

interface UsersRepository
{
    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email);

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user);
}
