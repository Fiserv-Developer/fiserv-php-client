<?php
use Fiserv\models\FiservObject;

class CheckoutCreatedResponse extends ResponseInterface
{
    public checkout $checkout;
}