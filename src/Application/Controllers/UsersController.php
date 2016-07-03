<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Exceptions\UserAlreadyExistsException;
use Gogordos\Application\StatusCode;
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

    /**
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $email = $request->getParam('email');
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        try {
            $registerUserRequest = new RegisterUserRequest($email, $username, $password);
            /** @var RegisterUserResponse $response */
            $response = $this->registerUserUseCase->execute($registerUserRequest);
        } catch (\Exception $e) {
            if ($e instanceof \InvalidArgumentException || $e instanceof UserAlreadyExistsException) {
                return ['status' => StatusCode::STATUS_ERROR, 'message' => $e->getMessage()];
            }
            return [
                'status' => StatusCode::STATUS_ERROR,
                'message' => 'Yuuups something went wrong. Message:' . $e->getMessage()
            ];
        }

        $data = ['status' => $response->code()];

        return $data;
    }
}