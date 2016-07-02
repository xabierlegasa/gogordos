<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\UseCases\RegisterUserRequest;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Slim\Http\Request;

class UsersController
{
    /** @var RegisterUserUseCase */
    private $registerUserUseCase;
    
    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    public function register(Request $request)
    {
        $username = $request->getParam('username');
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        try {
            $registerUserRequest = new RegisterUserRequest($username, $email, $password);
            /** @var RegisterUserResponse $response */
            $response = $this->registerUserUseCase->execute($registerUserRequest);
        } catch (\Exception $e) {

        }


        $data = ['status' => $response->code()];

        return $data;
    }
}