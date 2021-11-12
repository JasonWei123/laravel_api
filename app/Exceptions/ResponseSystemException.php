<?php

namespace App\Exceptions;

use App\Http\Controllers\Controller;
use Exception;

class ResponseSystemException extends Exception
{
    public function __construct(string $code)
    {
        parent::__construct($code);
    }

    public function render()
    {
        $controller = new Controller();
        return $controller->failSystem($this->code);
    }
}

