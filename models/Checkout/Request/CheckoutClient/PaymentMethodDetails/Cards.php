<?php

namespace Fisrv\Models;

class Cards extends FisrvObject
{
    public AuthenticationPreferences $authenticationPreferences;

    public TokenBasedTransaction $tokenBasedTransaction;

    public string $brand;

    public string $cardNumber;

    public ExpiryDate $expiryDate;

    public CreateToken $createToken;

    /**
     * Constructor
     *
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false, bool $isReponseContent = false)
    {
        $this->requiredFields = [
            'createToken'
        ];

        FisrvObject::__construct($json, $isReponseContent);
    }
}
