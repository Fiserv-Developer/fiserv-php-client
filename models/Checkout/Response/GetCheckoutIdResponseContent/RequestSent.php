<?php

namespace Fisrv\Models;

class RequestSent extends FisrvObject
{
    public OrderDetails $orderDetails;

    public CheckoutSettings $checkoutSettings;

    public PaymentMethodDetails $paymentMethodDetails;

    public string $merchantTransactionId;
}
