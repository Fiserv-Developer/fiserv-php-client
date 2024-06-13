<?php

use Fiserv\models\FiservObject;

class Order extends FiservObject
{
    public string $orderId;
    public OrderDetails $orderDetails;
    public string $basket;
    public Billing $billing;
    public Billing $shipping;
}
