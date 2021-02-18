<?php
namespace App\Utils;

use App\Utils\ReadArrayInterface;
use ParseError;

class ReadArray implements ReadArrayInterface
{
    /** @var string $file File name */
    protected $file;

    function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Read content from file and return array
     * 
     * @return array
     */
    public function readArrayFromFile()
    {
        try {
            $a = eval("return " . file_get_contents($this->file)); # I know that using eval is terrible
        } catch (ParseError $e) {
            print("There is an error in txt file with a raw array");
            die();
        }

        return $a;
    }
}