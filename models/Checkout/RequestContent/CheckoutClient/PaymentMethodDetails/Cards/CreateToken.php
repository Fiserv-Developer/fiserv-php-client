<?php

namespace Fiserv\Models;


class CreateToken extends FiservObject
{
    public bool $declineDuplicateToken;
    public bool $reusable;
    public ToBeUsedFor $toBeUsedFor;
    public bool $declineDuplicates;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'toBeUsedFor',
        ];

        FiservObject::__construct($json);
    }
}
