<?php

namespace Fisrv\Models;

class PaymentMethodUsed extends FisrvObject
{
    public Cards $cards;

    public TokenBasedTransaction $tokenBasedTransaction;

    public PayPal $payPal;

    public string $paymentMethodType;
}
