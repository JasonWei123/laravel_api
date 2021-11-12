<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Exception;

class InvalidRequestException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function render()
    {
        $controller = new Controller();
        return $controller->fail($this->message);
    }
}

