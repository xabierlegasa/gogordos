<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Exceptions\AuthenticationException;
use Gogordos\Application\Presenters\RestaurantPresenter;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsRequest;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsResponse;
use Gogordos\Application\UseCases\GetRestaurantsOfFriends\GetRestaurantsOfFriendsUseCase;
use Gogordos\Domain\AppConstants;
use Slim\Http\Request;

class GetRestaurantsOfFriendsController
{
    /**
     * @var GetRestaurantsOfFriendsUseCase
     */
    private $getRestaurantsOfFriendsUseCase;

    /**
     * @var RestaurantPresenter
     */
    private $restaurantPresenter;

    /**
     * @param GetRestaurantsOfFriendsUseCase $getRestaurantsOfFriendsUseCase
     * @param RestaurantPresenter $restaurantPresenter
     */
    public function __construct(
        GetRestaurantsOfFriendsUseCase $getRestaurantsOfFriendsUseCase,
        RestaurantPresenter $restaurantPresenter
    ) {
        $this->getRestaurantsOfFriendsUseCase = $getRestaurantsOfFriendsUseCase;
        $this->restaurantPresenter = $restaurantPresenter;
    }

    public function getRestaurantsOfFriends(Request $request)
    {
        try {
            /** @var GetRestaurantsOfFriendsResponse $response */
            $response = $this->getRestaurantsOfFriendsUseCase->execute(
                new GetRestaurantsOfFriendsRequest(
                    $request->getParam('jwt'),
                    (int) $request->getParam('page'),
                    AppConstants::HOMEPAGE_NUM_RESTAURANTS_OF_FRIENDS_PER_PAGE
                )
            );

            $restaurantsPresented = $this->restaurantPresenter->presentRestaurantsWithUserData($response->restaurants);

            return new JsonOk([
                'pagination' => [
                    'currentPage' => $response->page,
                    'totalPages' => $response->totalPages
                ],
                'restaurants' => $restaurantsPresented
            ]);
        } catch (AuthenticationException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => $e->getMessage()]);
        }
    }
}
