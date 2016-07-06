<?php

namespace Gogordos\Application\Controllers;

use Gogordos\Application\StatusCode;
use Gogordos\Application\UseCases\AuthenticateRequest;
use Gogordos\Application\UseCases\AuthenticateUseCase;
use Slim\Http\Request;

class AuthenticationController
{
    /**
     * @var AuthenticateUseCase
     */
    private $authenticateUseCase;

    /**
     *
     * @param AuthenticateUseCase $authenticateUseCase
     */
    public function __construct(AuthenticateUseCase $authenticateUseCase)
    {
        $this->authenticateUseCase = $authenticateUseCase;
    }

    public function authenticate(Request $request)
    {
        try {
            $jwt = $request->getParam('jwt');

            $response = $this->authenticateUseCase->execute(new AuthenticateRequest($jwt));
            $authUserData = $response->authUserData();
            
            return [
                'status' => StatusCode::STATUS_SUCCESS,
                'user' => [
                    'username' => $authUserData->username(),
                ]
            ];


        } catch (\Exception $e) {
            // TODO: Log the error.
            return [
                'status' => StatusCode::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

    }
}