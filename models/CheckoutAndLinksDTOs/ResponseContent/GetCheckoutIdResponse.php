<?php

use Fiserv\models\FiservObject;

class GetCheckoutIdResponse extends ResponseInterface
{
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public ApprovedAmount $approvedAmount;
    public string $transactionStatus;
    public RequestSent $requestSent;
    public PaymentLink $paymentLink;
}
