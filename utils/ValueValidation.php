<?php
namespace App\Utils;

use App\Utils\ValueValidationInterface;

class ValueValidation implements ValueValidationInterface
{
    /**
     * Simple value validation
     * 
     * @return bool 
     */
    public static function validate($value)
    {
        if (is_array($value) || is_object($value) || is_callable($value) || is_resource($value)) {
            return false;
        } else {
            return true;
        }
    }
}