<?php
namespace App\Model;

use App\Utils\ValueValidation;
use App\Model\ArrayModelInterface;

class ArrayModel implements ArrayModelInterface
{
    /** @var array $raw_array An input array that needs to be printed as a table */
    protected $raw_array;

    /** @var array $array_keys An array of keys from raw array */
    protected $array_keys;

    /** @var array $cells_max_length An array of maximum length of values for each key in raw array */
    protected $cells_max_length;

    /**
     * The construct function generates an array of unique keys and 
     * gets the longest string in the column from the raw array
     * 
     * @param array $raw_array A raw input array 
     */
    function __construct(array $raw_array)
    {
        if ($raw_array) {
            $this->raw_array = $raw_array;
            $this->array_keys = $this->setArrayKeys();
            $this->cells_max_length = $this->setCellsMaxLength();
        } else {
            die("The array is empty");
        }
    }
    
    /**
     * Getter for the $cells_max length
     * 
     * @return array
     */
    public function getCellsMaxlength(): Array
    {
        return $this->cells_max_length;
    }

    /**
     * Getter for the $array_keys length
     * 
     * @return array
     */
    public function getArrayKeys(): Array
    {
        return $this->array_keys;
    }

    /**
     * Set a keys from the raw array
     * 
     * The function iterates through the raw array and collects unique keys.
     * 
     * @return array An array of sorted keys from the raw array.
     */
    protected function setArrayKeys(): Array
    {
        $new_array = array();

        foreach ($this->raw_array as $inner_array) {
            if (is_array($inner_array))
                $new_array = array_unique(array_merge($new_array, array_keys($inner_array)));
        }
        sort($new_array);
        return $new_array;
    }

    /**
     * The generator that returns an array of values for each key from the raw array.
     * 
     * The function goes through the raw array and appends to the temporary
     * array values if the inner array has a key from the $array_keys array.
     * 
     * @return array
     */
    protected function getColumnArray()
    {
        $formatted_array = array();
        foreach ($this->array_keys as $key_name) {

            $formatted_array[$key_name] = array();

            foreach ($this->raw_array as $inner_array) {
                #FIX array to string
                if (array_key_exists($key_name, $inner_array) and ValueValidation::validate($inner_array[$key_name]))
                    array_push($formatted_array[$key_name], $inner_array[$key_name]);
                else
                    array_push($formatted_array[$key_name], "");
            }

            yield $formatted_array;
            $formatted_array = array();
        }
    }

    /**
     * Returns an array of the longest strings for every key in
     * the raw array.
     * 
     * The function iterates through the generator and looks for the longest string
     * in the column, then returns the array with longest values for each column.
     * 
     * @return array An array of the longest string in a column
     */
    protected function setCellsMaxLength(): Array
    {
        $maxCellslength = array();
        $maxLength = null;
        foreach ($this->getColumnArray() as $generator_arr) {
            foreach ($generator_arr as $key => $inner_arr) {
                foreach ($inner_arr as $item) {
                    if(ValueValidation::validate($item)) {
                        $length = mb_strlen($item);
                        if (is_null($maxLength) || $length > $maxLength)
                            $maxLength = $length;
                    }
                }
                $maxCellslength[] = $maxLength > mb_strlen($key) ? $maxLength : mb_strlen($key);
                $maxLength = 0;
            }
        }

        return $maxCellslength;
    }
}