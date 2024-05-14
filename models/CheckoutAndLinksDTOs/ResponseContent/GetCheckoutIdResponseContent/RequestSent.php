<?php

use Fiserv\models\FiservObject;

class requestSent extends FiservObject
{
    public orderDetails $orderDetails;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
}
