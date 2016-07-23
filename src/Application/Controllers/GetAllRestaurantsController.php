<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Domain\AppConstants;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Slim\Http\Request;

class GetAllRestaurantsController
{
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function getRestaurants(Request $request)
    {
        try {
            $page = (int) $request->getParam('page', 1);
            if ($page == 0) $page = 1; //if no page var is given, default to 1
            $limit = AppConstants::NUM_RESTAURANTS_PER_PAGE;
            $offset = ($page - 1) * $limit;
            $total = $this->restaurantRepository->countAll();
            $restaurants = $this->restaurantRepository->findAllPaginated($offset, AppConstants::NUM_RESTAURANTS_PER_PAGE);
            // How many pages will there be
            $pages = ceil($total / $limit);

            return new JsonOk([
                'pagination' => [
                    'currentPage' => $page,
                    'totalPages' => $pages
                ],
                'restaurants' => $restaurants
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        }
    }
}
