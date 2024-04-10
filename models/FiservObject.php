<?php

namespace Fiserv\models;

abstract class FiservObject
{
    public function __construct($json = false)
    {
        if ($json)
            $this->set(json_decode($json, true));
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = self::createFromName($key);
                $value->set(json_encode($value));
            }
            $this->{$key} = $value;
        }
    }

    public static function createFromName(string $name): FiservObject
    {
        switch ($name) {
            case 'transactionAmount':
                return new \TransactionAmount();

            case 'checkoutSettings':
                return new \CheckoutSettings();

            case 'paymentMethodDetails':
                return new \PaymentMethodDetails();

            case 'checkout':
                return new \CheckoutModel();

            default:
                throw new NoObjectMappingFoundException("No valid mapping found for field: " . $name);
        }
    }
}

class NoObjectMappingFoundException extends \Exception
{
    public $message = "No valid mapping found for some field";
}