<?php

use Fiserv\models\FiservObject;

class orderDetails extends FiservObject
{
    public string $customerId;
    public string $dynamicMerchantName;
    public string $invoiceNumber;
    public string $purchaseOrderNumber;
}
