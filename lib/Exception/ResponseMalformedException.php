<?php

namespace Fiserv\Exception;

use Exception;

class ResponseMalformedException extends Exception
{
    public function __construct()
    {
        $this->message = 'Response is of malformed type';
    }
}
