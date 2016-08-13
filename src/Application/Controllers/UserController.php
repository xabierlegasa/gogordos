<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Presenters\RestaurantPresenter;
use Gogordos\Application\UseCases\GetUserRestaurants\GetUserRestaurantsUseCase;
use Slim\Http\Request;

class UserController
{
    /**
     * @var GetUserRestaurantsUseCase
     */
    private $getUserRestaurantsUseCase;

    /**
     * @var RestaurantPresenter
     */
    private $restaurantPresenter;

    /**
     * UserController constructor.
     * @param GetUserRestaurantsUseCase $getUserRestaurantsUseCase
     * @param RestaurantPresenter $restaurantPresenter
     */
    public function __construct(
        GetUserRestaurantsUseCase $getUserRestaurantsUseCase,
        RestaurantPresenter $restaurantPresenter
    ) {
        $this->getUserRestaurantsUseCase = $getUserRestaurantsUseCase;
        $this->restaurantPresenter = $restaurantPresenter;
    }

    public function getRestaurantsOfUser(Request $request)
    {
        try {
            $username = $request->getParam('username');
            $response = $this->getUserRestaurantsUseCase->execute($username);
            $restaurantsPresented = $this->restaurantPresenter->presentRestaurantsWithUserData($response->restaurants);

            return new JsonOk(
                [
                    'restaurants' => $restaurantsPresented,
                    'user' => $response->user->username()
                ]
            );
        } catch (\Exception $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}
