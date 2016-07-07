<?php

namespace Gogordos\Application\UseCases;

use Gogordos\Domain\Entities\AuthUserData;
use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Services\Authenticator;

class AuthenticateUseCase
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * AuthenticateUseCase constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {

        $this->authenticator = $authenticator;
    }
    /**
     * @param AuthenticateRequest $request
     * @return AuthenticateResponse
     */
    public function execute(AuthenticateRequest $request)
    {
        $jwt = $request->jwt();
        
        if (empty($jwt)) {
            throw new \InvalidArgumentException('Authorization token (jwt) is missing');
        }

        /** @var AuthUserData $authUserData */
        $authUserData = $this->authenticator->authUserDataFromToken($jwt);
        
        $response = new AuthenticateResponse($authUserData);
        
        return $response;
    }
}
