<?php
/**
 * Created by PhpStorm.
 * User: xabi
 * Date: 03/07/16
 * Time: 11:36
 */

namespace Gogordos\Application\Exceptions;


class UsernameAlreadyExistsException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}