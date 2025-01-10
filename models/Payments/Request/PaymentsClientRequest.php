<?php

namespace Fisrv\Models;

class PaymentsClientRequest extends RequestInterface
{
    public string $requestType;

    public TransactionAmount $transactionAmount;

    public PaymentMethod $paymentMethod;

    public function __construct(array|string|false $json = false)
    {
        FisrvObject::__construct($json);
    }
}
