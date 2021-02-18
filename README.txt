The entry point of the project is in the main.php file. Put a properly shaped array, 
like in example into <filename>.txt file in the root directory of the project and run the command:

php main.php <filename>.txt

Input array example:
array(
    array(
        'House' => 'Baratheon',
        'Sigil' => 'A crowned stag',
        'Motto' => 'Ours is the Fury',
        ),
    array(
        'Leader' => 'Eddard Stark',
        'House' => 'Stark',
        'Motto' => 'Winter is Coming',
        'Sigil' => 'A grey direwolf'
        ),
    array(
        'House' => 'Lannister',
        'Leader' => 'Tywin Lannister',
        'Sigil' => 'A golden lion'
        ),
    array(
	      'Q' => 'Z'
    )
);

If everything is good you'll see the formatted table in the output.

=========================================================================
|     House |           Leader |            Motto | Q |           Sigil |
-------------------------------------------------------------------------
| Baratheon |                  | Ours is the Fury |   |  A crowned stag |
|     Stark |     Eddard Stark | Winter is Coming |   | A grey direwolf |
| Lannister |  Tywin Lannister |                  |   |   A golden lion |
|           |                  |                  | Z |                 |
=========================================================================

1. ReadArray class: 
    - reads the input file
    - produces a raw array ready to be consumed by the main process
2. ArrayModel class:
    - gets the raw array in constructor
    - processes the array: picks the keys and sets the size of cells for the table
3. ArrayLineGenerator class:
    - yields the properly shaped array of values for the table line
4. ValueValidation class:
    - has a static function that accepts the value of an array as an argument and validates it
5. Table class:
    - accepts 3 arguments: labels of the columns, length of the cells, ArrayLineGenerator object
    - formats length of the cells
    - outputs the table to the console