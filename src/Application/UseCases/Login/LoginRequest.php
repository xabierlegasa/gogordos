<?php

namespace Gogordos\Application\UseCases\Login;


class LoginRequest
{
    /** @var string */
    private $password;
    
    /** @var string */
    private $emailOrUsername;

    /**
     * LoginRequest constructor.
     * @param $emailOrUsername
     * @param $password
     */
    public function __construct($emailOrUsername, $password)
    {
        $this->emailOrUsername = $emailOrUsername;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function emailOrUsername()
    {
        return $this->emailOrUsername;
    }
}
