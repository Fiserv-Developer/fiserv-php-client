<?php

class InvalidFieldException extends Exception
{
    public function __construct(string $field, string $class)
    {
        $this->message = "Field " . $field . " doesn't exist on Model " . $class . ". May be typo on field name or unimplemented Field.";
    }
}