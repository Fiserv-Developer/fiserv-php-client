<?php

namespace Fisrv\Exception;

use Exception;

class BadRequestException extends Exception
{
    public string $title;
    public string $detail;
    public string $source;

    public function __construct(int $statusCode, string $message, string $traceId)
    {
        $decoded = json_decode($message, true);

        if (!is_array($decoded)) {
            $this->message = strval($statusCode) . ': ' . $message;
            return;
        }

        $errors = $decoded['errors'];
        $parse = "\n";

        foreach ($errors as $error) {
            foreach ($error as $key => $value) {
                $parse = $parse . $value . "\n";
            }
            $parse = $parse . "\n";
        }
        $parse = $parse . "Trace-Id: " . $traceId . "\n";

        $this->message = strval($statusCode) . ': ' . $parse;
    }
}
