<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\User;

interface UsersRepository
{
    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail($email);

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user);
}