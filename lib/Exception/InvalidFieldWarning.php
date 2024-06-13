<?php

namespace Fiserv\Exception;

class InvalidFieldWarning
{
    public function __construct(string $field, string $class)
    {
        $message = "Field " . $field . " doesn't exist on Model " . $class . ". May be typo on field name or unimplemented Field.";
        trigger_error($message, E_USER_WARNING);
    }
}
