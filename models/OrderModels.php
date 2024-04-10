<?php

namespace Fiserv\models;

class Order
{
    private string $orderId;
    private string $purposeOfPaymentCode;
    private string $billing;
    private string $shipping;
    private string $serviceLocation;
    private string $industrySpecificExtensions;
    private string $PurchaseCard;
    private string $ip;
    private string $installmentOptions;
    private string $revolvingOptions;
    public string $standInDetails;
    private string $stnadInDetails;
    private string $tokenCryptogram;
    private string $softDescriptor;
    private string $additionalDetails;
    private string $bancontactQR;
    private string $clientLocale;
    private string $basket;
    private string $recurringPaymentDetails;
    private string $accountOwner;
    private string $deliveryDetails;
}

class StandInDetails
{
    private \StandInType $standInType;
    private bool $siValidated;
    private string $frequency;
}

class AdditionalDetails
{
    private \StandInType $standInType;
    private bool $siValidated;
    private \Frequency $frequency;
}

class Receipts
{
    private \ReceiptType $type;
}

class BancontactQR
{
    private string $transactionRoutingMeans;
}

class RecurringPaymentDetails
{
    private string $additionalDetails;
    private \Frequency $frequency;
    private AdditionalRecurringData $additionalRecurringData;
}

class AdditionalRecurringData
{
    private bool $validationIndicator;
}

class PaymentMethod
{
    private PaymentFacilitator $paymentFacilitator;
}

class PaymentFacilitator
{
    private SubMerchantData $subMerchantData;
}

class SubMerchantData
{
    private \DocumentType $document;
}