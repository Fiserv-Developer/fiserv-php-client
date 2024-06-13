<?php

use Fiserv\models\FiservObject;

class PaymentMethodUsed extends FiservObject
{
    public Cards $cards;
    public TokenBasedTransaction $tokenBasedTransaction;
    public PayPal $payPal;
    public string $paymentMethodType;
}
