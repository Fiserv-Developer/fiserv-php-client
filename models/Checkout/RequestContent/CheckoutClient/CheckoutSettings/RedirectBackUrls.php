<?php

namespace Fiserv\Models;
use Fiserv\Exception\ValidationException;

class RedirectBackUrls extends FiservObject implements ValidationInterface
{
    public string $successUrl;
    public string $failureUrl;

    /**
     * Constructor 
     * 
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false, bool $isReponseContent = false)
    {
        $this->pattern = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)/m';
        parent::__construct($json, $isReponseContent);
    }

    /**
     * When implemented this should be used to check
     * fields of current object for validity (e.g. string pattern check on 
     * URLs) as per API specification.
     */
    public function validate(): void
    {
        foreach (get_class_vars($this) as $field => $value) {

            $isFieldOfDto = !property_exists(parent::class, $field);

            if ($isFieldOfDto && is_string($value) && $this->pattern != false) {
                $match = preg_match($this->pattern, $value);
                if (!$match) {
                    throw new ValidationException($value, $field);
                }
            }
        }
    }
}
