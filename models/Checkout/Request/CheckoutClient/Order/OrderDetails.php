<?php

namespace Fisrv\Models;

class OrderDetails extends fisrvObject
{
    public string $customerId;
    public string $dynamicMerchantName;
    public string $invoiceNumber;
    public string $purchaseOrderNumber;
}
