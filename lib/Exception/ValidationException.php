<?php

namespace Fisrv\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(string $value, mixed $field, string $details = null)
    {
        $this->message = $value . " value could not be validated as field " . $field . '.';

        if (!is_null($details)) {
            $this->message .= $details;
        }
    }
}
