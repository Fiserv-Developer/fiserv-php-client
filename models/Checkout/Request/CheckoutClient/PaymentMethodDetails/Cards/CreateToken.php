<?php

namespace Fisrv\Models;


class CreateToken extends fisrvObject
{
    public bool $declineDuplicateToken;
    public bool $reusable;
    public ToBeUsedFor $toBeUsedFor;
    public bool $declineDuplicates;

    /**
     * Constructor 
     * 
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false)
    {
        $this->requiredFields = [
            'toBeUsedFor',
        ];

        fisrvObject::__construct($json);
    }
}
