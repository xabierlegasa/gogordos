<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantRequest;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantResponse;
use Gogordos\Application\UseCases\AddRestaurant\AddRestaurantUseCase;
use Respect\Validation\Validator;
use Slim\Http\Request;

class AddRestaurantController
{
    const RESTAURANT_LENGTH_MIN = 2;
    const RESTAURANT_LENGTH_MAX = 255;
    const CITY_LENGTH_MIN = 2;
    const CITY_LENGTH_MAX = 255;

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
            $restaurantName = $request->getParam('restaurant_name');
            $name = ucwords(strtolower($restaurantName));
            $this->checkRestaurantIsValid($restaurantName);

            $city = strtolower($request->getParam('restaurant_city'));
            $this->checkCityIsValid($city);


            $category = $request->getParam('restaurant_category');
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
            return new JsonBadRequest(['errorMessage' => $e->getMessage()]);
        }
    }

    /**
     * @param string $restaurant
     */
    private function checkRestaurantIsValid($restaurant)
    {
        $usernameValidator = Validator::stringType()
            // put this to allow underscore also
            //->alnum('_')
            ->alnum()
            ->length(
                static::RESTAURANT_LENGTH_MIN,
                static::RESTAURANT_LENGTH_MAX
            );

        if (!$usernameValidator->validate($restaurant)) {
            throw new \InvalidArgumentException(
                'El nombre del restaurante solo puede contener letras o números, y máximo '
                . static::RESTAURANT_LENGTH_MAX
                . ' caracteres.'
            );
        }
    }

    /**
     * @param $city
     */
    private function checkCityIsValid($city)
    {
        $usernameValidator = Validator::stringType()
            ->alpha()
            ->length(
                static::CITY_LENGTH_MIN,
                static::CITY_LENGTH_MAX
            );

        if (!$usernameValidator->validate($city)) {
            throw new \InvalidArgumentException(
                'La ciudad solo puede contener letras, y máximo '
                . static::CITY_LENGTH_MAX
                . ' caracteres.'
            );
        }
    }
}
