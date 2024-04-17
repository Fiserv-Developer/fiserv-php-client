<?php
use Fiserv\models\FiservObject;

class CheckoutCreatedResponse extends FiservObject
{
    public checkout $checkout;
}