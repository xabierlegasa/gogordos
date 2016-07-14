<?php

namespace Gogordos\Application\UseCases\AddRestaurant;


use Gogordos\Domain\Entities\Restaurant;
use Gogordos\Domain\Repositories\CategoryRepository;
use Gogordos\Domain\Repositories\RestaurantRepository;

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
     * AddRestaurantUseCase constructor.
     * @param CategoryRepository $categoryRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        RestaurantRepository $restaurantRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    public function execute(AddRestaurantRequest $addRestaurantRequest)
    {
        $name = $addRestaurantRequest->name();
        $city = $addRestaurantRequest->city();
        $categoryName = $addRestaurantRequest->category();


        if (empty($name)) {
            throw new \InvalidArgumentException('El nombre del restaurante no puede estar vacío');
        }

        if (empty($city)) {
            throw new \InvalidArgumentException('La ciudad no puede estar vacía');
        }

        if (empty($categoryName)) {
            throw new \InvalidArgumentException('La categoría del restaurante no puede estar vacío');
        }

        /** @var Category $category */
        $category = $this->categoryRepository->findByName($categoryName);

        if (empty($category)) {
            throw new \InvalidArgumentException('La categoría no es válida');
        }

        /** @var Restaurant $restaurant */
        $restaurant = new Restaurant($name, $city, $category);
        $this->restaurantRepository->save($restaurant);

        $response = new AddRestaurantResponse($restaurant);
        return $response;
    }
}