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
     * @param string $email
     * @param string $username
     * @return User|null
     */
    public function findByEmailOrUsername($email, $username);
    
    /**
     * Insert a user in the DB. Returns true if successful, or false otherwise
     * @param User $user
     * @return bool
     */
    public function save(User $user);
}
