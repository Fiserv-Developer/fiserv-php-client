<?php

namespace Fisrv\Models;

class GetCheckoutIdResponse extends ResponseInterface
{
    public string $storeId;

    public string $checkoutId;

    public string $orderId;

    public string $transactionType;

    public ApprovedAmount $approvedAmount;

    public TransactionStatus $transactionStatus;

    public RequestSent $requestSent;

    public PaymentLink $paymentLink;
}
