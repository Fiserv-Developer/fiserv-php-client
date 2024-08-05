<?php

namespace Fisrv\Models;

use Fisrv\Models\Traits\Token;

class CreateToken extends FisrvObject
{
    use Token;

    public bool $declineDuplicateToken;

    public ToBeUsedFor $toBeUsedFor;

    /**
     * Constructor
     *
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array|string|false $json = false)
    {
        $this->requiredFields = [
            'toBeUsedFor',
        ];

        FisrvObject::__construct($json);
    }
}
