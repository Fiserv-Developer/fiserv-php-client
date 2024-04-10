<?php

namespace Fiserv\Exceptions;

class ErrorHandler
{
    public string $title;
    public string $detail;
}

class MalformedRequestException extends \Exception
{
    public $message = "Request is malformed";
}