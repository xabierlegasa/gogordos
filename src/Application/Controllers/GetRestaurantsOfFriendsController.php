<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Exceptions\AuthenticationException;
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
     * @param GetRestaurantsOfFriendsUseCase $getRestaurantsOfFriendsUseCase
     */
    public function __construct(GetRestaurantsOfFriendsUseCase $getRestaurantsOfFriendsUseCase)
    {
        $this->getRestaurantsOfFriendsUseCase = $getRestaurantsOfFriendsUseCase;
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

            return new JsonOk([
                'pagination' => [
                    'currentPage' => $response->page,
                    'totalPages' => $response->totalPages
                ],
                'restaurants' => $response->restaurants
            ]);
        } catch (AuthenticationException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => $e->getMessage()]);
        }
    }
}
