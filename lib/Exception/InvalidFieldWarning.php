<?php

namespace Fisrv\Exception;

class InvalidFieldWarning
{
    public function __construct(string $field, string $class, string | false $detailMessage = false)
    {
        $message = "Field " . $field . " doesn't exist on Model " . $class . ". May be typo on field name or unimplemented Field.";

        if ($detailMessage) {
            $message .= ' ' . $detailMessage;
        }

        trigger_error($message, E_USER_NOTICE);
    }
}
