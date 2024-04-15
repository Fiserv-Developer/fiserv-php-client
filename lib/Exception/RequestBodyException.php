<?php
use Fiserv\RequestType;

class RequestBodyException extends Exception
{
    public function __construct(RequestType $type)
    {
        $message = "Invalid Request. " . $type . " request needs (no) request body.";
    }
}