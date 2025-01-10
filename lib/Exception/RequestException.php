<?php

namespace Fisrv\Exception;

use Exception;

class RequestException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
