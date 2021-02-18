<?php
namespace App;
use App\Model\ArrayModel;
use App\Utils\ArrayLineGenerator;
use App\Views\Table;
use App\Utils\ReadArray;

require "autoload.php";

/**
 * The entry point of the program. Calls the functions to read 
 * an array from the file, executes operations on it and output the table.
 * 
 * @param string $filename Name of the file with a raw array.
 */
function main(string $filename)
{
    if (preg_match("/([A-z0-9]*)(\.)(txt)/", $filename) && file_exists($filename)) {
        $readArrayObject = new ReadArray($filename);
    } else {
        exit("Wrong filename or file does not exist");
    }
    
    $raw_array = $readArrayObject->readArrayFromFile();
    
    $arrayObject = new ArrayModel($raw_array);
    $arrayObjectGenerator = new ArrayLineGenerator($raw_array, $arrayObject->getArrayKeys());
    $table = new Table($arrayObject->getArrayKeys(), $arrayObject->getCellsMaxlength(), $arrayObjectGenerator);
    $table->printTable();
}

main($argv[1]);
