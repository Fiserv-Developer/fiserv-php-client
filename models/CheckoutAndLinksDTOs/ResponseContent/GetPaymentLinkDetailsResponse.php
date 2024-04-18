<?php
use Fiserv\models\FiservObject;

class GetPaymentLinkDetailsResponse extends ResponseInterface
{
    public string $storeId;
    public paymentLink $paymentLink;
    public string $checkoutId;
    public string $orderId;
    public approvedAmount $approvedAmount;
    public string $transactionType;
    public string $transactionStatus;
    public transactionFailure $transactionFailure;
    public paymentMethodUsed $paymentMethodUsed;
    public currencyConversion $currencyConversion;
    public ipgTransactionDetails $ipgTransactionDetails;
    public requestSent $requestSent;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
    public sepaDirectDebit $sepaDirectDebit;
    public payPal $payPal;

}