<?php
use Fiserv\models\FiservObject;

class paymentMethodDetails extends FiservObject
{
    public cards $cards;
    public sepaDirectDebit $sepaDirectDebit;
    public payPal $payPal;
    public tokenBasedTransaction $tokenBasedTransaction;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'cards',
        ];

        FiservObject::__construct($json);
    }
}