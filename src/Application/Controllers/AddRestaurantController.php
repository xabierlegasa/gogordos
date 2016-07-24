<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantRequest;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantResponse;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use Slim\Http\Request;

class AddRestaurantController
{
    /**
     * @var AddRestaurantUseCase
     */
    private $addRestaurantUseCase;

    /**
     * AddRestaurantController constructor.
     * @param AddRestaurantUseCase $addRestaurantUseCase
     */
    public function __construct(AddRestaurantUseCase $addRestaurantUseCase)
    {
        $this->addRestaurantUseCase = $addRestaurantUseCase;
    }

    public function addRestaurant(Request $request)
    {
        try {
            $name = ucwords(strtolower($request->getParam('restaurant')['name']));
            $city = strtolower($request->getParam('restaurant')['city']);
            $category = $request->getParam('restaurant')['category'];
            $jwt = $request->getParam('jwt');
            /** @var AddRestaurantResponse $addRestaurantUseCaseResponse */
            $addRestaurantResponse = $this->addRestaurantUseCase->execute(
                new AddRestaurantRequest(
                    $name,
                    $city,
                    $category,
                    $jwt
                )
            );

            return new JsonOk([
                'restaurant' => $addRestaurantResponse->restaurant()
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}