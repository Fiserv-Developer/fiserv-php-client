<?php

namespace Fiserv\models;

use TransactionAmount;

abstract class FiservObject
{
    public function __construct($json = false)
    {
        if ($json)
            $this->set($json);
    }

    public function set($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $nestedObj = self::createFromName($key);
                $nestedObj->set($value);
                $value = $nestedObj;
            }
            $this->{$key} = $value;
        }
    }

    public static function createFromName(string $name): FiservObject
    {
        switch ($name) {
            case 'transactionAmount':
                return new TransactionAmount();

            case 'checkoutSettings':
                return new \CheckoutSettings();

            case 'paymentMethodDetails':
                return new \PaymentMethodDetails();

            case 'cards':
                return new \Cards();

            case 'authenticationPreferences':
                return new \AuthenticationPreferences();

            case 'createToken':
                return new \CreateToken();

            case 'tokenBasedTransaction':
                return new \TokenBasedTransaction();

            case 'sepaDirectDebit':
                return new \SepaDirectDebit();

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