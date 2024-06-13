<?php

use Fiserv\models\FiservObject;

class CheckoutClientRequest extends FiservObject
{
    public string $transactionOrigin;
    public string $transactionType;
    public TransactionAmount $transactionAmount;
    public checkoutSettings $checkoutSettings;
    public paymentMethodDetails $paymentMethodDetails;
    public string $merchantTransactionId;
    public string $storeId;
    public order $order;

    public function __construct($json = false)
    {
        $this->requiredFields = [
            'storeId',
            'transactionType',
            'transactionAmount',
            'paymentMethodDetails',
        ];

        FiservObject::__construct($json);
    }

    // public function withSuccessUrl(string $successUrl): CheckoutClientRequest
    // {
    //     $this->checkoutSettings->redirectBackUrls->successUrl = $successUrl;
    //     return $this;
    // }

    // public function withFailureUrl(string $failureUrl): CheckoutClientRequest
    // {
    //     $this->checkoutSettings->redirectBackUrls->failureUrl = $failureUrl;
    //     return $this;
    // }

    // public function withStoreId(string $storeId): CheckoutClientRequest
    // {
    //     $this->storeId = $storeId;
    //     return $this;
    // }

    // public function withAmount(float $amount): CheckoutClientRequest
    // {
    //     $this->transactionAmount->total = $amount;
    //     return $this;
    // }

    // public function withCurrency(string $currency): CheckoutClientRequest
    // {
    //     $this->transactionAmount->currency = $currency;
    //     return $this;
    // }

    // public static function start(): CheckoutClientRequest
    // {
    //     return new CheckoutClientRequest();
    // }
}
