<?php

use Fiserv\models\FiservObject;

/**
 * This interfaces handles validation of fields for
 * the API DTOs that need them
 */
trait ValidationTrait
{
    /**
     * When implemented this should be used to check
     * fields of current object for validity (e.g. string pattern check on 
     * URLs) as per API specification.
     * 
     * @param FiservObject $instance Instance to be checked
     */
    public function checkString(FiservObject $instance)
    {
        foreach ($instance as $field => $value) {

            $isFieldOfDto = !property_exists(parent::class, $field);

            if ($isFieldOfDto && is_string($value)) {
                $match = preg_match($instance->pattern, $value);
                if (!$match) {
                    throw new Exception($value . " is not a valid " . $field);
                }
            }
        }
    }
}
