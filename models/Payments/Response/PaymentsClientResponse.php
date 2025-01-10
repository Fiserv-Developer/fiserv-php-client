<?php

namespace Fisrv\Models;

use Fisrv\Models\Traits\PaymentsResponseHead;

class PaymentsClientResponse extends ResponseInterface
{
    use PaymentsResponseHead;

    public string $ipgTransactionId;

    public string $orderId;

    public TransactionType $transactionType;

    public CreateToken $paymentToken;

    public string $transactionOrigin;

    public PaymentMethodDetails $paymentMethodDetails;

    public string $country;

    public string $terminalId;

    public string $transactionTime;

    public ApprovedAmount $approvedAmount;

    public string $transactionStatus;

    public string $transactionAmount;

    public string $merchantId;

    public string $approvalCode;

    public string $schemeTransactionId;

    public string $securityCodeResponse;

    public Processor $processor;

    public AdditionalDetails $additionalDetails;

    public RequestSent $requestSent;

    public string $errorMessage;
}
