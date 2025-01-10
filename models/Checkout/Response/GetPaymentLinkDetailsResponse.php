<?php

namespace Fisrv\Models;

class GetPaymentLinkDetailsResponse extends ResponseInterface
{
    public string $storeId;

    public PaymentLink $paymentLink;

    public string $checkoutId;

    public string $orderId;

    public ApprovedAmount $approvedAmount;

    public TransactionType $transactionType;

    public string $transactionStatus;

    public TransactionFailure $transactionFailure;

    public PaymentMethodUsed $paymentMethodUsed;

    public CurrencyConversion $currencyConversion;

    public IpgTransactionDetails $ipgTransactionDetails;

    public RequestSent $requestSent;

    public CheckoutSettings $checkoutSettings;

    public PaymentMethodDetails $paymentMethodDetails;

    public SepaDirectDebit $sepaDirectDebit;

    public PayPal $payPal;
}
