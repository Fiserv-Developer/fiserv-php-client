<?php

namespace Fiserv\models;

use DataEncodingException;
use DynamicPropertyException;
use RequiredFieldMissingException;

abstract class FiservObject
{
    protected array $requiredFields = [];

    public function __construct($json = false)
    {
        if ($json) {
            $this->set($json);
        }

        foreach ($this->requiredFields as $field) {
            if (!isset($this->{$field})) {
                throw new RequiredFieldMissingException($field, $this::class);
            }
        }
    }

    private function set($data)
    {
        if (is_string($data)) {
            throw new DataEncodingException($data);
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $nestedObj = new $key($value);
                $value = $nestedObj;
            }

            if (!property_exists($this, $key)) {
                throw new DynamicPropertyException($key, $this::class);
            }

            $this->{$key} = $value;
        }
    }
}