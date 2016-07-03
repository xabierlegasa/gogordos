<?php

namespace Gogordos\Application\UseCases;


class RegisterUserRequest
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    public function __construct($email, $username, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }
}
