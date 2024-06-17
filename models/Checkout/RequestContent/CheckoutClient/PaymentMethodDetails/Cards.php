<?php

namespace Fiserv\Models;

class Cards extends FiservObject
{
    public AuthenticationPreferences $authenticationPreferences;
    public TokenBasedTransaction $tokenBasedTransaction;
    public string $brand;
    public string $cardNumber;
    public ExpiryDate $expiryDate;
    public CreateToken $createToken;

    public function __construct($json = false, $isReponseContent = false)
    {
        $this->requiredFields = [
            'createToken',
        ];

        FiservObject::__construct($json, $isReponseContent);
    }
}
