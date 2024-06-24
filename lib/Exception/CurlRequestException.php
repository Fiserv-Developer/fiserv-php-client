<?php

namespace Fisrv\Exception;

use Exception;

class CurlRequestException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}
