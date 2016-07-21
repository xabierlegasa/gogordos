<?php

namespace Gogordos\Application\UseCases\GetUserRestaurants;


use Gogordos\Application\Exceptions\UserDoesNotExistException;
use Gogordos\Domain\Repositories\RestaurantRepository;
use Gogordos\Domain\Repositories\UsersRepository;

class GetUserRestaurantsUseCase
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var RestaurantRepository
     */
    private $restaurantRepository;

    /**
     * GetUserRestaurantsUseCase constructor.
     * @param UsersRepository $usersRepository
     * @param RestaurantRepository $restaurantRepository
     */
    public function __construct(
        UsersRepository $usersRepository,
        RestaurantRepository $restaurantRepository
    )
    {
        $this->usersRepository = $usersRepository;
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * @param $username
     * @return GetUserRestaurantsResponse
     * @throws UserDoesNotExistException
     */
    public function execute($username)
    {
        $user = $this->usersRepository->findByUsername($username);

        if (empty($user)) {
            throw new UserDoesNotExistException('El usuario no existe');
        }
        
        $restaurants = $this->restaurantRepository->findByUser($user);
        
        return new GetUserRestaurantsResponse($user, $restaurants);
    }
}
