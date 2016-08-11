<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Presenters\RestaurantPresenter;
use Gogordos\Domain\AppConstants;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Slim\Http\Request;

class GetCityRestaurantsController
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
     * GetAllRestaurantsController constructor.
     * @param RestaurantRepository $restaurantRepository
     * @param RestaurantPresenter $restaurantPresenter
     */
    public function __construct(RestaurantRepository $restaurantRepository, RestaurantPresenter $restaurantPresenter)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->restaurantPresenter = $restaurantPresenter;
    }

    public function getRestaurants(Request $request)
    {
        try {
            $cityName = strtolower($request->getParam('city'));
            $page = (int) $request->getParam('page', 1);
            if ($page == 0) $page = 1; //if no page var is given, default to 1
            $limit = AppConstants::HOMEPAGE_NUM_RESTAURANTS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            $total = $this->restaurantRepository->countAllByCity($cityName);
            // How many pages will there be
            $pages = ceil($total / $limit);

            $restaurants = $this->restaurantRepository->findByCityPaginated($cityName, $offset, AppConstants::HOMEPAGE_NUM_RESTAURANTS_PER_PAGE);
            $restaurantsPresented = $this->restaurantPresenter->presentRestaurantsWithUserData($restaurants);

            return new JsonOk([
                'pagination' => [
                    'currentPage' => $page,
                    'totalPages' => $pages
                ],
                'restaurants' => $restaurantsPresented
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}
