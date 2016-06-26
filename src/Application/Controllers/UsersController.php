<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\UseCases\RegisterUserRequest;
use Gogordos\Application\UseCases\RegisterUserUseCase;

class UsersController
{
    /** @var RegisterUserUseCase */
    private $registerUserUseCase;
    
    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register($request)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        $registerUserRequest = new RegisterUserRequest($username, $email, $password);
        $response = $this->registerUserUseCase->execute($registerUserRequest);

        $json = json_encode(['response_code' => $response->code()]);

        return $json;
    }
}