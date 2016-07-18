<?php

namespace Gogordos\Application\UseCases\GetUserRestaurants;


use Gogordos\Application\Exceptions\UserDoesNotExistException;
use Gogordos\Domain\Repositories\UsersRepository;

class GetUserRestaurantsUseCase
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * GetUserRestaurantsUseCase constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
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
        
        $restaurants = $this->restaurantsRepository->findByUserId($user->id());
        
        return new GetUserRestaurantsResponse($user, $restaurants);
    }
}
