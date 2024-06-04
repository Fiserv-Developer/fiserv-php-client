<?php

use Fiserv\models\FiservObject;

class CreateCheckoutRequest extends FiservObject
{
    public string $transactionOrigin;
    public string $transactionType;
    public transactionAmount $transactionAmount;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;
    public order $order;

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
