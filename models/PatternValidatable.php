<?php

/**
 * This interfaces handles validation of fields for
 * the API DTOs that need them
 */
trait PatternValidatable
{
    /**
     * When implemented this should be used to check
     * fields of current object for validity (e.g. string pattern check on 
     * URLs) as per API specification.
     */
    public function validate($instance, string $pattern)
    {
        foreach ($instance as $field => $value) {
            if (is_string($value)) {
                $match = preg_match($pattern, $value);

                if (!$match) {
                    throw new Exception($value . " is not a valid " . $field);
                }
            }
        }
    }
}
