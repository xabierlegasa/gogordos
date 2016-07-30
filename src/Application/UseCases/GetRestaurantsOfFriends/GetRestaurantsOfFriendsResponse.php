<?php

namespace Gogordos\Application\UseCases\GetRestaurantsOfFriends;


class GetRestaurantsOfFriendsResponse
{
    /** @var array */
    public $restaurants;
    /** @var int */
    public $page;
    /** @var int */
    public $totalPages;

    public function __construct(array $restaurants, $page, $totalPages)
    {
        $this->page = $page;
        $this->totalPages = $totalPages;
        $this->restaurants = $restaurants;
    }
}
