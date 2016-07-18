<?php

namespace Gogordos\Application\UseCases\GetUserRestaurants;

use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\User;

class GetUserRestaurantsResponse
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var Restaurant[]
     */
    public $restaurants;

    /**
     * @param User $user
     * @param array $restaurants
     */
    public function __construct(User $user, array $restaurants)
    {
        $this->user = $user;
        $this->restaurants = $restaurants;
    }
}
