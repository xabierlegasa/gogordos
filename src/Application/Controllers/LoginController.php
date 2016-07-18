<?php

namespace Gogordos\Application\Controllers;


use Gogordos\Application\Controllers\Response\JsonBadRequest;
use Gogordos\Application\Controllers\Response\JsonOk;
use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\Login\LoginRequest;
use Gogordos\Application\UseCases\Login\LoginResponse;
use Gogordos\Application\UseCases\Login\LoginUseCase;
use Gogordos\Domain\Services\Authenticator;
use Slim\Http\Request;

class LoginController
{
    /**
     * @var LoginUseCase
     */
    private $loginUseCase;
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @param LoginUseCase $loginUseCase
     * @param Authenticator $authenticator
     */
    public function __construct(LoginUseCase $loginUseCase, Authenticator $authenticator)
    {
        $this->loginUseCase = $loginUseCase;
        $this->authenticator = $authenticator;
    }

    public function login(Request $request)
    {
        try {
            $emailOrUsername = $request->getParam('emailOrUsername');
            $password = $request->getParam('password');

            /** @var LoginResponse $response */
            $response = $this->loginUseCase->execute(new LoginRequest($emailOrUsername, $password));

            $jwt = $this->authenticator->authTokenFromUser($response->user());

            return new JsonOk(
                [
                    'username' => $response->user()->username(),
                    'jwt' => $jwt
                ]
            );
        } catch (\Exception $e) {
            return new JsonBadRequest(
                ['message' => 'Los datos no coinciden con ninguna cuenta']
            );
        }
    }
}
