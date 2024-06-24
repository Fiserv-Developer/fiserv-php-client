<?php

namespace Fisrv\Exception;

use Exception;
use Fisrv\HttpClient\RequestType;

class RequestBodyException extends Exception
{
    public function __construct(RequestType $type)
    {
        $message = "Invalid Request. " . $type->value . " request needs (no) request body.";
    }
}
