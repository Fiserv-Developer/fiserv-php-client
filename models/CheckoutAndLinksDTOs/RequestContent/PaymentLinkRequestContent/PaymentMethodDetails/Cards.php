<?php
use Fiserv\models\FiservObject;

class cards extends FiservObject
{
    public authenticationPreferences $authenticationPreferences;
    public tokenBasedTransaction $tokenBasedTransaction;
    public createToken $createToken;

    public function __construct($json = false, $isReponseContent = false)
    {
        $this->requiredFields = [
            'createToken',
        ];

        FiservObject::__construct($json, $isReponseContent);
    }
}