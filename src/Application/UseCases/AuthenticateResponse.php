<?php

namespace Gogordos\Application\UseCases;

use Gogordos\Domain\Entities\AuthUserData;

class AuthenticateResponse
{
    /**
     * @var AuthUserData
     */
    private $authUserData;

    /**
     * AuthenticateResponse constructor.
     * @param AuthUserData $authUserData
     */
    public function __construct(AuthUserData $authUserData)
    {
        $this->authUserData = $authUserData;
    }
    
    public function authUserData()
    {
        return $this->authUserData;
    }
}
