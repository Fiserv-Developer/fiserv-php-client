<?php

namespace Fiserv\Models;

class OrderDetails extends FiservObject
{
    public string $customerId;
    public string $dynamicMerchantName;
    public string $invoiceNumber;
    public string $purchaseOrderNumber;
}
