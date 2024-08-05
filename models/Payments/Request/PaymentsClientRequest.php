<?php

namespace Fisrv\Models;

class PaymentsClientRequest extends RequestInterface
{
    public string $requestType;

    public TransactionAmount $transactionAmount;

    public PaymentMethod $paymentMethod;
}
