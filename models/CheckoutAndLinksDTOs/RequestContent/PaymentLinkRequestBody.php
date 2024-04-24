<?php

use Fiserv\models\FiservObject;

class PaymentLinkRequestBody extends FiservObject
{
    public string $transactionOrigin;
    public string $transactionType;
    public transactionAmount $transactionAmount;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'storeId',
            'transactionType',
            'transactionAmount',
            'paymentMethodDetails',
        ];

        FiservObject::__construct($json);
    }
}
