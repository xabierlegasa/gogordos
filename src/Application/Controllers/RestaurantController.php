<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantRequest;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantResponse;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use Slim\Http\Request;

class RestaurantController
{
    /**
     * @var AddRestaurantUseCase
     */
    private $addRestaurantUseCase;

    /**
     * RestaurantController constructor.
     * @param AddRestaurantUseCase $addRestaurantUseCase
     */
    public function __construct(AddRestaurantUseCase $addRestaurantUseCase)
    {
        $this->addRestaurantUseCase = $addRestaurantUseCase;
    }

    public function addRestaurant(Request $request)
    {
        $name = $request->getParam('name');
        $city = $request->getParam('city');
        $restaurant = $request->getParam('category');

        try {
            /** @var AddRestaurantResponse $addRestaurantUseCaseResponse */
            $addRestaurantResponse = $this->addRestaurantUseCase->execute(
                new AddRestaurantRequest(
                    $name,
                    $city,
                    $restaurant
                )
            );

            return new JsonOk(
                [
                    'restaurant' => $addRestaurantResponse->restaurant()
                ]
            );
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}