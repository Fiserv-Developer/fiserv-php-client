<?php
use Fiserv\models\FiservObject;

class PaymentLinksRequest extends FiservObject
{
    public string $transactionOrigin;
    public string $transactionType;
    public TransactionAmount $transactionAmount;
    public CheckoutSettings $checkoutSettings;
    public PaymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;
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

class CheckoutSettings extends FiservObject
{
    public string $locale;
}

class PaymentMethodDetails extends FiservObject
{
    public Cards $cards;
    public SepaDirectDebit $sepaDirectDebit;
}

class Cards extends FiservObject
{
    public AuthenticationPreferences $authenticationPreferences;
    public CreateToken $createToken;
    public TokenBasedTransaction $tokenBasedTransaction;
}

class AuthenticationPreferences extends FiservObject
{
    public string $challengeIndicator;
    public bool $skipTra;
}

class CreateToken extends FiservObject
{
    public bool $declineDuplicateToken;
    public bool $reusable;
    public string $toBeUsedFor;
}

class SepaDirectDebit extends FiservObject
{
    public string $transactionSequenceType;
}

class TokenBasedTransaction extends FiservObject
{
    public string $transactionSequence;
}