<?php

namespace Fiserv\Models;

class PaymentMethodUsed extends FiservObject
{
    public Cards $cards;
    public TokenBasedTransaction $tokenBasedTransaction;
    public PayPal $payPal;
    public string $paymentMethodType;
}
