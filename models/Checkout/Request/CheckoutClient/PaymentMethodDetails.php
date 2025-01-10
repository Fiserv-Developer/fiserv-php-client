<?php

namespace Fisrv\Models;

class PaymentMethodDetails extends FisrvObject
{
    public Cards $cards;

    public SepaDirectDebit $sepaDirectDebit;

    public PayPal $payPal;

    public PaymentCard $paymentCard;

    public string $paymentMethodType;

    public string $paymentMethodBrand;

    public function __construct(array|string|false $json = false, bool $isReponseContent = false)
    {
        $this->requiredFields = [
            'cards'
        ];

        FisrvObject::__construct($json, $isReponseContent);
    }
}
