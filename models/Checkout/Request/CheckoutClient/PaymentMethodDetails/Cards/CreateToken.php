<?php

namespace Fisrv\Models;

class CreateToken extends FisrvObject
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

        FisrvObject::__construct($json);
    }
}
