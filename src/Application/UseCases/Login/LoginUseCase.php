<?php

namespace Gogordos\Application\UseCases\Login;


use Gogordos\Domain\Repositories\UsersRepository;

class LoginUseCase
{
    /**
     * @var UsersRepository
     */
    private $usersRepository;

    /**
     * LoginUseCase constructor.
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param LoginRequest $loginRequest
     * @return LoginResponse
     */
    public function execute(LoginRequest $loginRequest)
    {
        $user = $this->usersRepository->findByEmailOrUsernameSingleParameter($loginRequest->emailOrUsername());

        if (null === $user) {
            throw new \InvalidArgumentException('User not found or invalid credentials');
        }

        return new LoginResponse($user);
    }
}
