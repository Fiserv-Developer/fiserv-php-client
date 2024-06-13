<?php

use Fiserv\models\FiservObject;

class order extends FiservObject
{
    public string $orderId;
    public orderDetails $orderDetails;
    public string $basket;
    public billing $billing;
    public billing $shipping;
}
