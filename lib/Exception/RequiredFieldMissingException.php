<?php

class RequiredFieldMissingException extends Exception
{
    public function __construct(string $field)
    {
        $this->message = "Required Field " . $field . " is missing";
    }
}