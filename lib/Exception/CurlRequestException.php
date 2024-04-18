<?php

class CurlRequestException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
    }
}