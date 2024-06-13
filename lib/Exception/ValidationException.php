<?php

namespace Fiserv\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $value, mixed $field)
    {
        $this->message = $value . " is not a valid " . $field;
    }
}
