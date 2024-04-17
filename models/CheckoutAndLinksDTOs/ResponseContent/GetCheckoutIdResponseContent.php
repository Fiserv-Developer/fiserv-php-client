<?php
use Fiserv\models\FiservObject;

class GetCheckoutIdResponseContent extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public approvedAmount $approvedAmount;
    public string $transactionStatus;
    public requestSent $requestSent;
    public paymentLink $paymentLink;
}