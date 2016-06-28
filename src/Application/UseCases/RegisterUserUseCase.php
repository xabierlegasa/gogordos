<?php

namespace Gogordos\Application\UseCases;

use Gogordos\domain\repositories\UsersRepository;

class RegisterUserUseCase
{
    /** @var  UsersRepository */
    private $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function execute(RegisterUserRequest $registerUserRequest)
    {
        $user = $this->usersRepository->findByEmail($registerUserRequest->email());
        
        if ($user) {
            throw new UserAlreadyExistsException('User already exists');
        }

        



        return new RegisterUserResponse('success');
    }
}