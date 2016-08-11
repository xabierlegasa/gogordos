<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonInternalServerError;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\Controllers\Response\JsonResponse;
use Gogordos\Application\Exceptions\EmailAlreadyExistsException;
use Gogordos\Application\Exceptions\UsernameAlreadyExistsException;
use Gogordos\Application\UseCases\RegisterUserRequest;
use Gogordos\Application\UseCases\RegisterUserResponse;
use Gogordos\Application\UseCases\RegisterUserUseCase;
use Slim\Http\Request;

class RegisterController
{
    /** @var RegisterUserUseCase */
    private $registerUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $email = $request->getParam('email');
        $username = $request->getParam('username');
        $password = password_hash($request->getParam('password'), PASSWORD_DEFAULT);

        try {
            $registerUserRequest = new RegisterUserRequest($email, $username, $password);
            /** @var RegisterUserResponse $response */
            $response = $this->registerUserUseCase->execute($registerUserRequest);

            $data = [
                'jwt' => $response->jwt()
            ];

            return new JsonOk($data);
        } catch (\Exception $e) {
            if ($e instanceof \InvalidArgumentException
                || $e instanceof EmailAlreadyExistsException
                || $e instanceof UsernameAlreadyExistsException
            ) {
                return new JsonBadRequest([
                    'errorMessage' => $e->getMessage()
                ]);
            }

            return new JsonInternalServerError([
                'errorMessage' => 'Yuuups something went wrong. Message:' . $e->getMessage()
            ]);
        }
    }
}
