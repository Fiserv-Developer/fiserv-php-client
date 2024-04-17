<?php
use Fiserv\models\FiservObject;

class RequestSent extends FiservObject
{
    public orderDetails $orderDetails;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
}
