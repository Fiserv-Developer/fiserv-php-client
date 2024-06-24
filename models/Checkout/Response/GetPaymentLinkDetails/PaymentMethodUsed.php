<?php

namespace Fisrv\Models;

class PaymentMethodUsed extends fisrvObject
{
    public Cards $cards;
    public TokenBasedTransaction $tokenBasedTransaction;
    public PayPal $payPal;
    public string $paymentMethodType;
}
