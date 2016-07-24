<?php

namespace Gogordos\Domain\Repositories;

use Gogordos\Domain\Entities\Friend;

interface FriendRepository
{
    public function save(Friend $friendship);

    public function exists(Friend $friend);
}
