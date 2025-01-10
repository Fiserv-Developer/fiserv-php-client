<?php

namespace Fisrv\Models;

class GetCheckoutIdResponse extends ResponseInterface
{
    public string $storeId;

    public string $checkoutId;

    public string $orderId;

    public TransactionType $transactionType;

    public ApprovedAmount $approvedAmount;

    public TransactionStatus $transactionStatus;

    public RequestSent $requestSent;

    public PaymentLink $paymentLink;

    public IpgTransactionDetails $ipgTransactionDetails;

    public PaymentMethodUsed $paymentMethodUsed;

    public TransactionFailure $transactionFailure;

    /** @var array<Error> $errors */
    public array $errors;
}
