<?php
/**
 * Created by PhpStorm.
 * User: xabi
 * Date: 06/07/16
 * Time: 00:22
 */

namespace Gogordos\Application\UseCases;


class AuthenticateRequest
{
    private $jwt;

    /**
     * AuthenticateRequest constructor.
     * @param $jwt
     */
    public function __construct($jwt)
    {
        $this->jwt = $jwt;
    }

    public function jwt()
    {
        return $this->jwt;
    }
}