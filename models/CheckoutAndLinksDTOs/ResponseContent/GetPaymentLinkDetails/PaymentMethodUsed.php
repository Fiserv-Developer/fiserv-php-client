<?php
use Fiserv\models\FiservObject;

class paymentMethodUsed extends FiservObject
{
    public cards $cards;
    public tokenBasedTransaction $tokenBasedTransaction;
    public payPal $payPal;
    public string $paymentMethodType;
}