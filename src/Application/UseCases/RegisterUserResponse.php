<?php
/**
 * Created by PhpStorm.
 * User: xabi
 * Date: 26/06/16
 * Time: 11:30
 */

namespace Gogordos\Application\UseCases;


use Gogordos\Domain\Entities\User;

class RegisterUserResponse
{
    /** @var string */
    private $code;

    /** @var User */
    private $user;

    /** @var string */
    private $jwt;

    /**
     * RegisterUserResponse constructor.
     * @param $code
     * @param User $user
     * @param string $jwt
     */
    public function __construct($code, User $user = null, $jwt = null)
    {
        $this->code = $code;
        $this->user = $user;
        $this->jwt = $jwt;
    }
    
    public function code()
    {
        return $this->code;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    public function jwt()
    {
        return $this->jwt;
    }
}