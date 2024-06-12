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
    public TransactionStatus $transactionStatus;
    public paymentMethodUsed $paymentMethodUsed;
    public ipgTransactionDetails $ipgTransactionDetails;
    public string $receivedAt;
}
