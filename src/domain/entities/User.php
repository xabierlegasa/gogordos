<?php

namespace Gogordos\domain\entities;


class User
{
    private $username;
    
    private $email;
    
    private $password;
    
    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }
}