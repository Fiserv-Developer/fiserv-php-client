<?php

namespace Fisrv\Models;

class PaymentLink extends fisrvObject
{
    public string $storeId;
    public string $orderId;
    public string $paymentLinkId;
    public string $paymentLinkUrl;
    public string $active;
    public string $expiryDateTime;
}
