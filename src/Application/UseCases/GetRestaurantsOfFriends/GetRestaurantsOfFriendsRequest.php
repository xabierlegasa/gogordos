<?php

namespace Gogordos\Application\UseCases\GetRestaurantsOfFriends;


class GetRestaurantsOfFriendsRequest
{
    /** @var string */
    public $jwt;
    /** @var int */
    public $page;
    /** @var int */
    public $rpp;

    /**
     * GetRestaurantsOfFriendsRequest constructor.
     * @param string $jwt
     * @param int $page
     * @param $rpp
     */
    public function __construct($jwt, $page, $rpp)
    {
        $this->jwt = $jwt;
        $this->page = $page;
        $this->rpp = $rpp;
    }
}
