<?php
use Fiserv\models\FiservObject;

class PaymentLinkData extends FiservObject
{
    public string $transactionOrigin;
    public string $transactionType;
    public TransactionAmount $transactionAmount;
    public CheckoutSettings $checkoutSettings;
    public PaymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'storeId',
            'transactionType',
            'transactionAmount',
            'paymentMethodDetails'
        ];

        FiservObject::__construct($json);
    }
}

class PaymentsLinksCreatedResponse extends FiservObject
{
    public PaymentLink $paymentLink;
}

class PaymentLink extends FiservObject
{
    public string $storeId;
    public string $orderId;
    public string $paymentLinkId;
    public string $paymentLinkUrl;
    public string $active;
    public string $expiryDateTime;
}

class CheckoutCreatedResponse extends FiservObject
{
    public checkout $checkout;
}

class checkout extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $redirectionUrl;
}

class TransactionAmount extends FiservObject
{
    public int $total;
    public string $currency;
}

class createToken extends FiservObject
{
    public bool $declineDuplicateToken;
    public bool $reusable;
    public string $toBeUsedFor;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'toBeUsedFor',
        ];

        FiservObject::__construct($json);
    }
}