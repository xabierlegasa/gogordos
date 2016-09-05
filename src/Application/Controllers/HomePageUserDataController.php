<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Controllers\Response\JsonResponse;
use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Repositories\UsersRepository;
use Gogordos\Domain\Services\Authenticator;
use Slim\Http\Request;

class HomePageUserDataController
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var Authenticator
     */
    private $authenticator;
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    /**
     * HomePageUserDataController constructor.
     * @param Authenticator $authenticator
     * @param UsersRepository $usersRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        Authenticator $authenticator,
        UsersRepository $usersRepository,
        RestaurantRepository $restaurantRepository
    ) {
        $this->authenticator = $authenticator;
        $this->usersRepository = $usersRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getData(Request $request)
    {
        try {
            /** @var AuthUserData $authUserData */
            $authUserData = $this->authenticator->authUserDataFromToken($request->getParam('jwt'));
            $username = $authUserData->username();
            $user = $this->usersRepository->findByUsername($username);
            $userId = $user->id()->value();
            $following = $this->usersRepository->getFollowing($userId);
            $followers = $this->usersRepository->getFollowers($userId);

            $restaurantsNumber = count($this->restaurantRepository->findByUserId($userId));

            return new JsonOk([
                'following_number' => count($following),
                'followers_number' => count($followers),
                'restaurants_number' => $restaurantsNumber
            ]);
        } catch (\InvalidArgumentException $e) {
            return new JsonBadRequest(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return new JsonInternalServerError(['message' => 'Yuups, something is bad with the server.']);
        }
    }
}
