<?php

namespace Gogordos\Application\UseCases\AddRestaurant;

use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Entities\UserId;
use Gogordos\Domain\Repositories\CategoryRepository;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Services\Authenticator;

class AddRestaurantUseCase
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * AddRestaurantUseCase constructor.
     * @param CategoryRepository $categoryRepository
     * @param RestaurantRepository $restaurantRepository
     * @param Authenticator $authenticator
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        RestaurantRepository $restaurantRepository,
        Authenticator $authenticator
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->restaurantRepository = $restaurantRepository;
        $this->authenticator = $authenticator;
    }

    public function execute(AddRestaurantRequest $addRestaurantRequest)
    {
        $name = $addRestaurantRequest->name();
        $city = $addRestaurantRequest->city();
        $categoryName = $addRestaurantRequest->category();
        $reason = $addRestaurantRequest->reason();

        if (empty($name)) {
            throw new \InvalidArgumentException('El nombre del restaurante no puede estar vacío');
        }

        if (empty($city)) {
            throw new \InvalidArgumentException('La ciudad no puede estar vacía');
        }

        if (empty($categoryName)) {
            throw new \InvalidArgumentException('La categoría del restaurante no puede estar vacío');
        }

        if (empty($reason)) {
            throw new \InvalidArgumentException('Indica por qué te gusta el sitio');
        }

        /** @var Category $category */
        $category = $this->categoryRepository->findByName($categoryName);

        if (empty($category)) {
            throw new \InvalidArgumentException('La categoría no es válida');
        }

        $token = $addRestaurantRequest->jwt();
        /** @var AuthUserData $authUserData */
        $authUserData = $this->authenticator->authUserDataFromToken($token);
        /** @var UserId $userId */
        $userId = $authUserData->userId()->value();

        /** @var Restaurant $restaurant */
        $restaurant = new Restaurant(null, $name, $city, $category, $userId, $reason, null);
        $restaurant = $this->restaurantRepository->save($restaurant);

        $response = new AddRestaurantResponse($restaurant);
        return $response;
    }
}
