<?php

namespace Fisrv\Exception;

use Exception;

class RequiredFieldMissingException extends Exception
{
    public function __construct(string $field, string $class)
    {
        $this->message = "Required field " . $field . " is missing on " . $class;
    }
}
