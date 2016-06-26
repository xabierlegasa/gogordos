<?php
/**
 * Created by PhpStorm.
 * User: xabi
 * Date: 26/06/16
 * Time: 11:30
 */

namespace Gogordos\Application\UseCases;


class RegisterUserResponse
{
    /** @var string */
    private $code;
    
    public function __construct($code)
    {
        $this->code = $code;
    }
    
    public function code()
    {
        return $this->code;
    }
}