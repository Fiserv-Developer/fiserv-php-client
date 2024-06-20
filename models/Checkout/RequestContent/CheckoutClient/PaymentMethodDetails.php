<?php

namespace Fiserv\Models;

class PaymentMethodDetails extends FiservObject
{
    public Cards $cards;
    public SepaDirectDebit $sepaDirectDebit;
    public PayPal $payPal;
    public TokenBasedTransaction $tokenBasedTransaction;

    public function __construct(array | string | false $json = false, bool $isReponseContent = false)
    {
        $this->requiredFields = [
            'cards',
        ];

        FiservObject::__construct($json, $isReponseContent);
    }
}
