<?php

namespace Fisrv\Models;

use Error;
use Exception;
use Fisrv\Exception\InvalidFieldWarning;
use Fisrv\Exception\RequiredFieldMissingException;
use ReflectionProperty;
use TypeError;

/**
 * This class handles serialization and field validation for DTO from JSON server responses and requests.
 * Every DTO sub class inherits this class.
 */
abstract class FisrvObject
{
    /**
     * List containing references to required fields.
     * Has to be ignored if not request.
     *
     * @var array<string>
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
    protected string|false $pattern = false;

    private const NAMESPACE_PREFIX = __NAMESPACE__ . '\\';

    /**
     * Constructor which calls setter.
     * If $isResponseContent flag ist true, the fields should not be validated.
     *
     * @param array<string, mixed> | string | false $json If not false, a JSON string to be serialized to DTO.
     * @param bool $isResponseContent True if object is a response
     */
    public function __construct(array|string|false $json = false, bool $isResponseContent = false)
    {
        $this->isResponseContent = $isResponseContent;

        /** Ensure JSON payload is array */
        if (is_string($json)) {
            $json = json_decode($json, true);
        }

        /** Is JSON valid? */
        if (is_null($json)) {
            throw new Exception('JSON payload is invalid');
        }

        /** Serialize */
        if ($json) {
            $this->set($json);
        }

        /** Don't validate if object is a response */
        if ($this->isResponseContent) {
            return;
        }

        /** Check if all required properties are set */
        foreach ($this->requiredFields as $field) {
            if (!isset($this->{$field})) {
                throw new RequiredFieldMissingException($field, $this::class);
            }
        }
    }

    /**
     * Dependency injection which is used to serialize JSON data from server to PHP
     * objects and vice versa. The setter is recursively for nested objects.
     *
     * @param array<string, string | mixed | array<string, mixed>> $data JSON data which has to parsed and inject into current object and children.
     */
    private function set(array $data): void
    {
        foreach ($data as $key => $value) {
            /** Serialize nested properties */
            if (is_array($value)) {
                try {
                    $className = self::NAMESPACE_PREFIX . ucfirst($key);
                    $nestedObj = new $className($value, $this->isResponseContent);
                    $value = $nestedObj;
                } catch (Error $th) {
                    /** Handle lists */
                    if (!array_is_list($value) && !is_numeric(ucfirst($key))) {
                        new InvalidFieldWarning($key, $this::class, $th->getMessage(), json_encode($value));
                        continue;
                    }

                    $className = self::NAMESPACE_PREFIX . ucfirst($key);
                    if (!class_exists($className)) {
                        $className = rtrim($className, 's');
                    }

                    foreach ($value as &$item) {
                        $item = new $className($item, $this->isResponseContent);
                    }
                }

            }

            if (!property_exists($this, $key) && !$this->isResponseContent) {
                new InvalidFieldWarning($key, $this::class);
            }

            /** Handle enums */
            try {
                $this->{$key} = $value;
            } catch (TypeError $th) {
                $rp = new ReflectionProperty($this, $key);
                if (enum_exists(strval($rp->getType()))) {
                    $enumType = $rp->getName();
                    $className = self::NAMESPACE_PREFIX . ucfirst($enumType);
                    $this->{$key} = $className::from($value);
                }
            }
        }
    }

    protected function moveProperty(FisrvObject $instance, string $from, string $to): void
    {
        if (!isset($instance->{$to}) && isset($instance->{$from})) {
            $instance->{$to} = $instance->{$from};
        }
    }

    public function __toString(): string
    {
        $json = json_encode($this, JSON_PRETTY_PRINT);

        if (!$json) {
            $json = 'Could not parse object';
        }

        return $json;
    }
}
