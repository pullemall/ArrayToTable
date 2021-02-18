<?php
namespace App\Utils;

use App\Utils\ArrayLineGeneratorInterface;
use App\Utils\ValueValidation;

class ArrayLineGenerator implements ArrayLineGeneratorInterface
{
    /** @var array The full non-formatted array */
    protected $raw_array;
    
    /** @var array Keys from the non-formatted array */
    protected $array_keys;

    /**
     * @param array $raw_array The full non-formatted array
     * @param array $array_keys Keys from the non-formatted array
     */
    function __construct(array $raw_array, array $array_keys)
    {
        $this->raw_array = $raw_array;
        $this->array_keys = $array_keys;
    }

    /**
     * Generator function which generates arrays for the table outputs
     * 
     * The function iterates through the raw array in the outer loop and appends 
     * values to the temporary array if the inner array has a key from the array_keys. 
     * At the end of the inner loop, when it gathered all values, the function 
     * yields the temporary array.
     * 
     * @return array An array of strings for table
     */
    public function getLineArray()
    {
        $formatted_array = array();
        foreach ($this->raw_array as $inner_array) {
            foreach ($this->array_keys as $key_name) {
                if (array_key_exists($key_name, $inner_array) and ValueValidation::validate($inner_array[$key_name])) 
                    $formatted_array[$key_name] =  $inner_array[$key_name];
                else
                    $formatted_array[$key_name] = "";
            }

            yield $formatted_array;
            $formatted_array = array();
        }
    }
}
