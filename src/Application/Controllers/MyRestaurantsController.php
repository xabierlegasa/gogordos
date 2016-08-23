<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Presenters\RestaurantPresenter;
use Gogordos\Domain\AppConstants;
use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Services\Authenticator;
use Slim\Http\Request;

class MyRestaurantsController
{
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;
    /**
     * @var RestaurantPresenter
     */
    private $restaurantPresenter;
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * GetAllRestaurantsController constructor.
     * @param RestaurantRepository $restaurantRepository
     * @param RestaurantPresenter $restaurantPresenter
     * @param Authenticator $authenticator
     */
    public function __construct(
        RestaurantRepository $restaurantRepository,
        RestaurantPresenter $restaurantPresenter,
        Authenticator $authenticator
    ) {
        $this->restaurantRepository = $restaurantRepository;
        $this->restaurantPresenter = $restaurantPresenter;
        $this->authenticator = $authenticator;
    }

    public function getRestaurants(Request $request)
    {
        try {
            /** @var AuthUserData $authUserData */
            $authUserData = $this->authenticator->authUserDataFromToken($request->getParam('jwt'));
            $restaurants = $this->restaurantRepository->findByUserId($authUserData->userId()->value());
            $restaurantsPresented = $this->restaurantPresenter->presentRestaurantsWithUserData($restaurants);

            return new JsonOk([
                'restaurants' => $restaurantsPresented
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}
