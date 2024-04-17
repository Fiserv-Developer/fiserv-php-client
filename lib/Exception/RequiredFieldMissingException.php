<?php

class RequiredFieldMissingException extends Exception
{
    public function __construct(string $field, string $class)
    {
        $this->message = "Required Field " . $field . " is missing on " . $class;
    }
}