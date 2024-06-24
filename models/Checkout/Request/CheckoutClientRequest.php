<?php

namespace Fisrv\Models;


class CheckoutClientRequest extends RequestInterface
{
    public TransactionOrigin $transactionOrigin;
    public string $transactionType;
    public TransactionAmount $transactionAmount;
    public CheckoutSettings $checkoutSettings;
    public PaymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;
    public Order $order;

    public function __construct(array | string | false $json = false)
    {
        $this->requiredFields = [
            'storeId',
            'transactionType',
            'transactionAmount',
            'paymentMethodDetails',
        ];

        fisrvObject::__construct($json);
    }
}
