<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public $message;
    public $httpCode;
    public $data;

    public function __construct($message = "", $httpStatusCode = 422, $data = [])
    {
        $this->message = $message;
        $this->httpCode = $httpStatusCode;
        $this->data = $data;
        parent::__construct($message, $httpStatusCode);
    }
}
