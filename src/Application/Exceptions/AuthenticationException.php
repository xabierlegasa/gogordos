<?php

namespace Gogordos\Application\Exceptions;


class AuthenticationException extends BaseCustomException
{
    public function __construct()
    {
        parent::__construct('Authentication error.');
    }
}
