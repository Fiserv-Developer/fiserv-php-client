<?php

namespace Fiserv\Exception;

use Exception;

class ErrorHandler
{
    public string $title;
    public string $detail;
}

class MalformedRequestException extends Exception
{
    public $message = "Request is malformed";
}
