<?php

namespace Gogordos\Domain\Entities;


class User
{
    /** @var  UserId */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /**
     * @param UserId $userId
     * @param string $username
     * @param string $email
     * @param string $password
     */
    private function __construct(UserId $userId, $username, $email, $password)
    {
        $this->id = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Register a new User
     *
     * @param UserId $userId
     * @param Email $email
     * @param Username $username
     * @param Password $password
     * @return User
     */
    public static function register(UserId $userId, $email, $username, $password)
    {
        return new User($userId, $email, $username, $password);
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
     * @param UserId $id
     */
    private function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $username
     */
    private function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    private function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    private function setPassword($password)
    {
        $this->password = $password;
    }
}