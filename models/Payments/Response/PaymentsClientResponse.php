<?php

namespace Fisrv\Models;

class PaymentsClientResponse extends ResponseInterface
{
    public string $clientRequestId;

    public string $ipgTransactionId;

    public string $orderId;

    public string $transactionType;

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

    public string $type;

    public string $securityCodeResponse;

    public Processor $processor;

    public AdditionalDetails $additionalDetails;

    public RequestSent $requestSent;
}
