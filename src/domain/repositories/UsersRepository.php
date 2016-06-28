<?php

namespace Gogordos\domain\repositories;

use Gogordos\domain\entities\User;

interface UsersRepository
{
    public function save(User $user);
}