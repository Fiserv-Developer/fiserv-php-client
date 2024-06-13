<?php

use Fiserv\models\FiservObject;

class Cards extends FiservObject
{
    public AuthenticationPreferences $authenticationPreferences;
    public TokenBasedTransaction $tokenBasedTransaction;
    public CreateToken $createToken;

    public function __construct($json = false, $isReponseContent = false)
    {
        $this->requiredFields = [
            'createToken',
        ];

        FiservObject::__construct($json, $isReponseContent);
    }
}
