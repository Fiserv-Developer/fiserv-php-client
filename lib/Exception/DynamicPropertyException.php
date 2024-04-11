<?php

class DynamicPropertyException extends Exception
{
    public function __construct(string $field, string $class)
    {
        $this->message = "Tried to create dynamic property (deprecated). Field " . $field . " doesn't exist on Model " . $class . ".";
    }
}