<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\UseCases\GetUserRestaurants\GetUserRestaurantsUseCase;
use Slim\Http\Request;

class UserController
{
    /**
     * @var GetUserRestaurantsUseCase
     */
    private $getUserRestaurantsUseCase;

    /**
     * UserController constructor.
     * @param GetUserRestaurantsUseCase $getUserRestaurantsUseCase
     */
    public function __construct(GetUserRestaurantsUseCase $getUserRestaurantsUseCase)
    {
        $this->getUserRestaurantsUseCase = $getUserRestaurantsUseCase;
    }

    public function getRestaurantsOfUser(Request $request)
    {
        try {
            $username = $request->getParam('username');
            $response = $this->getUserRestaurantsUseCase->execute($username);
            
        } catch (\Exception $e) {
            
        }
    }
}
