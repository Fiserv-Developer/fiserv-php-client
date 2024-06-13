<?php

use Fiserv\models\FiservObject;

class PaymentLink extends FiservObject
{
    public string $storeId;
    public string $orderId;
    public string $paymentLinkId;
    public string $paymentLinkUrl;
    public string $active;
    public string $expiryDateTime;
}
