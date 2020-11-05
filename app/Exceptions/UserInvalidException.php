<?php

namespace App\Exceptions;

class UserInvalidException extends UserException
{
    public function __construct($message = "", $httpStatusCode = 422, $data = [])
    {
        parent::__construct($message, $httpStatusCode, $data);
    }
}
