<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Controllers\Response\JsonResponse;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Repositories\UsersRepository;
use Slim\Http\Request;

class FriendsController
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**ç
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    /**
     * FriendsController constructor.
     * @param UsersRepository $usersRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        UsersRepository $usersRepository,
        RestaurantRepository $restaurantRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFollowing(Request $request)
    {
        try {
            $username = $request->getParam('username');
            $user = $this->usersRepository->findByUsername($username);
            $userId = $user->id()->value();
            $items = $this->usersRepository->getFollowing($userId);

            $i = [];
            foreach ($items as $item) {
                $numRestaurantsOfUser = $this->restaurantRepository->countByUserId($item['userId']);
                $i[] = [
                    'username' => $item['username'],
                    'numRestaurants' => $numRestaurantsOfUser
                ];
            }

            return new JsonOk([
                'users' => $i
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => 'Yuups, something is bad with the server.']);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFollowers(Request $request)
    {
        try {
            $username = $request->getParam('username');
            $user = $this->usersRepository->findByUsername($username);
            $userId = $user->id()->value();
            $items = $this->usersRepository->getFollowers($userId);

            $i = [];
            foreach ($items as $item) {
                $numRestaurantsOfUser = $this->restaurantRepository->countByUserId($item['userId']);
                $i[] = [
                    'username' => $item['username'],
                    'numRestaurants' => $numRestaurantsOfUser
                ];
            }

            return new JsonOk([
                'users' => $i
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => 'Yuups, something is bad with the server.']);
        }
    }
}
