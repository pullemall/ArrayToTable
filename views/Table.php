<?php
namespace App\Views;

use App\Views\TableInterface;

class Table implements TableInterface
{
    /** @var array An array of the table column names */
    protected $table_keys;

    /** @var \App\Utils\ArrayLineGenerator An object with getLineArray() function which yields lines for the table */
    protected $lines;

    /** @var string Format of the table cells */
    protected $formatted_cells;

    /**
     * @param array $table_keys an array with names of columns for the table
     * @param array $cells_max_length an array of the longest values for each key
     * @param \App\Utils\ArrayLineGenerator $lines a generator of lines for the output
     */
    function __construct($table_keys, $cells_max_length, $lines)
    {
        $this->table_keys = $table_keys;
        $this->lines = $lines;
        $this->formatted_cells = $this->formatColumnSize($cells_max_length);
    }

    /**
     * Function for formatting columns size for the table.
     *
     * The function goes through the $cells_length array and dynamically 
     * configure columns length for the table.
     *
     * @param array $cells_length length of cells for table.
     *                           
     * @return string formatted table cells
     */
    protected function formatColumnSize(array $cells_length): string
    {
        $cells = "";

        foreach ($cells_length as $cell_width) {
            $cells .= "| %{$cell_width}s ";
        }

        $cells .= "|";

        return $cells;
    }

    /**
     * Gets the full size of the table and returns a formatted string of table border
     * 
     * @param int $output_len full length of table
     * 
     * @return string formatted table border
     */
    protected function getBorder(int $output_len): string
    {
        return sprintf("%'={$output_len}s", "=");
    }

    /**
     * Gets the full size of the table and returns a formatted string of table delimiter
     * 
     * @param int $output_len full length of table
     * 
     * @return string formatted table delimiter
     */
    protected function getDelimiter(int $output_len): string
    {
        return sprintf("%'-{$output_len}s", "-");
    }

    /**
     * Outputs table to console
     * 
     * The function takes one argument of formatted cells and formats
     * header of the table then gets a length of the output, creates border 
     * and delimiter, eventually prints full table through generator function
     * that returns lines for a table.
     *
     * @return int
     */
    public function printTable()
    {
        $header = vsprintf($this->formatted_cells, $this->table_keys);
        $output_len = mb_strlen($header);
        $border = $this->getBorder($output_len) . "\n";
        $delim = $this->getDelimiter($output_len) . "\n";
        
        print($border);
        print($header . "\n");
        print($delim);
        
        foreach ($this->lines->getLineArray() as $line)
            print(vsprintf($this->formatted_cells, $line) . "\n");

        print($border);

        return 0;
    }
}