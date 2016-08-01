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
    /** @var User */
    private $user;

    /** @var string */
    private $jwt;

    /**
     * RegisterUserResponse constructor.
     * @param User $user
     * @param string $jwt
     */
    public function __construct(User $user = null, $jwt = null)
    {
        $this->user = $user;
        $this->jwt = $jwt;
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
