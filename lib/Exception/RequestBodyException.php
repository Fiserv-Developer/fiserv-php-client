<?php

namespace Fiserv\Exception;

use Exception;
use Fiserv\HttpClient\RequestType;

class RequestBodyException extends Exception
{
    public function __construct(RequestType $type)
    {
        $message = "Invalid Request. " . $type . " request needs (no) request body.";
    }
}
