<?php

namespace Fisrv\Models;

class CreateToken extends FisrvObject
{
    public string $customTokenValue;

    public bool $declineDuplicateToken;

    public bool $declineDuplicates;

    public bool $reusable;

    public CustomWalletRegistration $customWalletRegistration;

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
