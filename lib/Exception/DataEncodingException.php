<?php

class DataEncodingException extends Exception
{

    public function __construct(string $field)
    {
        $this->message = "Data or field " . $field . " is a string, should be an array. Encoding is incorrect. (Probably using redundant json encoding)";
    }
}