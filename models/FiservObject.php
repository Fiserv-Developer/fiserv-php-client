<?php

namespace Fiserv\Models;

use Error;
use Fiserv\Exception\DataEncodingException;
use Fiserv\Exception\InvalidFieldWarning;
use Fiserv\Exception\RequiredFieldMissingException;

/**
 * This class handles serialization and field validation for DTO from JSON server responses and requests.
 * Every DTO sub class inherits this class.
 */
abstract class FiservObject
{
    /**
     * List containing references to required fields. 
     * Has to be ignored if not request.
     */
    protected array $requiredFields = [];

    /**
     * This flags an object as non-request. If data is not for a request
     * the require field checks are ignored.
     */
    protected bool $isResponseContent = false;

    /**
     * Regex pattern that may be used for certain fields for validation.
     * If pattern matching fails thow serialization/validation error to user.
     * No checking if false.
     */
    protected string | false $pattern = false;

    /**
     * Constructor which calls setter.
     * If $isResponseContent flag ist true, the fields should not be validated.
     * 
     * @param array|bool $json If not false, a JSON string to be serialized to DTO.
     * @param bool $isResponseContent True if object is a response
     */
    public function __construct(array | false $json = false, bool $isResponseContent = false)
    {
        $this->isResponseContent = $isResponseContent;

        if ($json) {
            $this->set($json);
        }

        if ($this->isResponseContent) {
            return;
        }

        foreach ($this->requiredFields as $field) {
            if (!isset($this->{$field})) {
                throw new RequiredFieldMissingException($field, $this::class);
            }
        }

        if ($this instanceof ValidationInterface) {
            $this->validate();
        }
    }

    /**
     * Dependency injection which is used to serialize JSON data from server to PHP
     * objects and vice versa. The setter is recursively for nested objects.
     * 
     * @param mixed $data JSON data which has to parsed and inject into current object and children.
     */
    private function set($data)
    {
        if (is_string($data)) {
            throw new DataEncodingException($data);
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                try {
                    $className = 'Fiserv\\Models\\' . ucfirst($key);
                    $nestedObj = new $className($value, $this->isResponseContent);
                } catch (Error $th) {
                    new InvalidFieldWarning($key, $this::class);
                    echo '===== FAILED HERE ' . $className;
                    // continue;
                }

                $value = $nestedObj;
            }

            // if (!property_exists($this, $key) && !$this->isResponseContent) {
            //     new InvalidFieldWarning($key, $this::class);
            // }

            $this->{$key} = $value;
        }
    }

    public function __toString()
    {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}
