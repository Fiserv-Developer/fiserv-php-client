<?php

namespace Fiserv\Models;

class RequestSent extends FiservObject
{
    public OrderDetails $orderDetails;
    public CheckoutSettings $checkoutSettings;
    public PaymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
}
