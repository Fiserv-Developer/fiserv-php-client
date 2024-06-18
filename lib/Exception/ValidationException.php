<?php

namespace Fiserv\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $value, mixed $field, string $details = '')
    {
        $this->message =  $value . " value could not be validated as field " . $field . '. ' . $details;
    }
}
