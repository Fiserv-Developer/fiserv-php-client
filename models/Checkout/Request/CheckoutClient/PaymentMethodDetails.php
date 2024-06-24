<?php

namespace Fisrv\Models;

class PaymentMethodDetails extends fisrvObject
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

        fisrvObject::__construct($json, $isReponseContent);
    }
}
