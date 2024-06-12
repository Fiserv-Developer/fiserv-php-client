<?php

use Fiserv\models\FiservObject;

class WebhookEvent extends FiservObject
{
    public int $retryNumber;
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public approvedAmount $approvedAmount;
    public transactionStatus | string $transactionStatus;
    public paymentMethodUsed $paymentMethodUsed;
    public ipgTransactionDetails $ipgTransactionDetails;
    public string $receivedAt;

    public function __construct($json = false, $isReponseContent = true)
    {
        $this->receivedAt = date("Y-m-d H:i:s");
        parent::__construct($json, $isReponseContent);
    }
}
