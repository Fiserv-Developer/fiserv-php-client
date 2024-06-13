<?php

use Fiserv\models\FiservObject;

class createToken extends FiservObject
{
    public bool $declineDuplicateToken;
    public bool $reusable;
    public string $toBeUsedFor;
    public bool $declineDuplicates;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'toBeUsedFor',
        ];

        FiservObject::__construct($json);
    }
}
