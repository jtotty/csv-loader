<?php declare(strict_types=1);

namespace Jtotty\Sorter;

use Port\Csv\CsvReader;

class Sorter
{
    /**
     * Holds an instance of SplFileObject
     * @var SplFileObject
     */
    private $file;

    /**
     * Holds an isntance of CsvReader
     * @var CsvReader
     */
    private $reader;

    /**
     * Database columns
     */
    protected $forename;
    protected $surname;
    protected $gender;
    protected $dob;
    protected $year;
    protected $reg;
    protected $eal;
    protected $premium;
    protected $meals;
    protected $care;

    /**
     * Constructor method
     */
    public function __constructor()
    {
        // $this->file   = new \SplFileObject('/files/abbscrossRM12-1343-import-20181024-5bd073a5bcafe.csv');
        // $this->reader = new CsvReader($file);
    }

    /**
     * Iterate over a csv file and output contents as associative array
     */
    public function iterateCsv()
    {
        // Make the rows associative arrays
        $file   = new \SplFileObject('files/csv_file.csv');
        $reader = new CsvReader($file);
        $reader->setHeaderRowNumber(0);

        $array = [];

        // Iterate over the CSV file
        foreach ($reader as $row) {
            array_push($array, $row);
        }

        var_export($array);
    }
}
