<?php

namespace Fiserv\models;

use checkout;
use CheckoutCreatedResponse;
use CheckoutModel;
use DataEncodingException;
use DynamicPropertyException;
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
        if (is_string($data)) {
            throw new DataEncodingException($data);
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $nestedObj = new $key;
                $nestedObj->set($value);
                $value = $nestedObj;
            }

            if (!property_exists($this, $key)) {
                throw new DynamicPropertyException($key, $this::class);
            }

            $this->{$key} = $value;
        }
    }
}

class NoObjectMappingFoundException extends \Exception
{
    public $message = "No valid mapping found for some field";
}