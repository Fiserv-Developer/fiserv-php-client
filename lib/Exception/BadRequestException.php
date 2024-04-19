<?php

class BadRequestException extends Exception
{
    public string $title;
    public string $detail;
    public string $source;

    public function __construct(string $statusCode, string $message, string $traceId)
    {
        $errors = json_decode($message, 1)['errors'];
        $parse = "\n";

        foreach ($errors as $error) {
            foreach ($error as $key => $value) {
                $parse = $parse . $value . "\n";
            }
            $parse = $parse . "\n";
        }
        $parse = $parse . "Trace-Id: " . $traceId . "\n";

        $this->message = $statusCode . ': ' . $parse;
    }
}