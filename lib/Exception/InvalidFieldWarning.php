<?php

namespace Fisrv\Exception;

class InvalidFieldWarning
{
    public function __construct(string $field, string $class, string|false $detailMessage = false, string|false $rawContent = false)
    {
        $message = "Field " . $field . " doesn't exist on Model " . $class . ". May be typo on field name or unimplemented Field.";

        if ($detailMessage) {
            $message .= ' ' . $detailMessage . '.';
        }

        if ($rawContent) {
            $message .= ' JSON content: ' . $rawContent;
        }

        print_r($message);
    }
}
