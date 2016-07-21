<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
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

            $restaurantData = [];
            foreach ($response->restaurants as $restaurant) {
                $restaurantData[] = [
                    'name' => $restaurant->name(),
                    'city' => $restaurant->city(),
                    'category' => $restaurant->category()->name(),
                    'category_es' => $restaurant->category()->nameEs(),
                ];
            }
            return new JsonOk(
                [
                    'restaurants' => $restaurantData,
                    'user' => $response->user->username()
                ]
            );
        } catch (\Exception $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}
