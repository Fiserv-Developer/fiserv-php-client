<?php

use Fiserv\models\FiservObject;

class order extends FiservObject
{
    public string $orderId;
    public orderDetails $orderDetails;
    public string $basket;
    public string $billing;
    public string $shipping;
}
