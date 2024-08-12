<?php

namespace Fisrv\Models;

class OrderDetails extends FisrvObject
{
    public string $customerId;

    public string $dynamicMerchantName;

    public string $invoiceNumber;

    public string $purchaseOrderNumber;

    public Basket $basket;

    public Billing $billing;
}
