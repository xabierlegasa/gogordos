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

    /**
     * RegisterUserResponse constructor.
     * @param $code
     * @param User $user
     */
    public function __construct($code, User $user = null)
    {
        $this->code = $code;
        $this->user = $user;
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
}