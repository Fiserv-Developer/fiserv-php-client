<?php

namespace Fisrv\Models;

class Order extends FisrvObject
{
    public string $orderId;

    public OrderDetails $orderDetails;

    public Basket $basket;

    public Billing $billing;

    public Billing $shipping;
}
