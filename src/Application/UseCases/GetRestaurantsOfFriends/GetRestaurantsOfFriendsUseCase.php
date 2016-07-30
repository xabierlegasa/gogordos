<?php

namespace Gogordos\Application\UseCases\GetRestaurantsOfFriends;


use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Services\Authenticator;

class GetRestaurantsOfFriendsUseCase
{
    /**
     * @var Authenticator
     */
    private $authenticator;
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    /**
     * GetRestaurantsOfFriendsUseCase constructor.
     * @param Authenticator $authenticator
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        Authenticator $authenticator,
        RestaurantRepository $restaurantRepository
    ) {
        $this->authenticator = $authenticator;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param GetRestaurantsOfFriendsRequest $request
     * @return GetRestaurantsOfFriendsResponse
     */
    public function execute(GetRestaurantsOfFriendsRequest $request)
    {
        /** @var AuthUserData $authUserData */
        $authUserData = $this->authenticator->authUserDataFromToken($request->jwt);
        $userId = $authUserData->userId();

        $limit = $request->rpp;
        $offset = ($request->page - 1) * $limit;

        $restaurants = $this->restaurantRepository->findByUserFriends($userId, $offset, $limit);
        $totalNumResults = $this->restaurantRepository->findByUserFriendsTotal($userId);
        $totalPages = ceil($totalNumResults/ $request->rpp);

        return new GetRestaurantsOfFriendsResponse($restaurants, $request->page, $totalPages);
    }
}
