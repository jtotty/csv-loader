<?php declare(strict_types=1);

namespace Jtotty\CsvLoader;

use \SplFileObject;
use Port\Csv\CsvReader;

class CsvLoader
{
    /**
     * Holds an instance of SplFileObject
     * @var SplFileObject
     */
    protected $file;

    /**
     * Holds an isntance of file contents as an associative array
     * @var Array
     */
    protected $contents;

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
    public function __constructor($file = null, $contents = [])
    {
        $this->file     = $file;
        $this->contents = $contents;
    }

    /**
     * Set the file to the SplFileObject
     * @param  String $file_path
     * @return void
     */
    public function setFile(String $file_path)
    {
        $this->file = new SplFileObject($file_path);
    }

    /**
     * Iterate over a csv file and output contents as associative array
     */
    public function iterateCsv()
    {
        // Make the rows associative arrays
        // $file   = new SplFileObject('files/csv_file.csv');
        $reader = new CsvReader($this->file);
        $reader->setHeaderRowNumber(0, CsvReader::DUPLICATE_HEADERS_INCREMENT);

        // Iterate over the CSV file
        $collection = [];
        foreach ($reader as $row) {
            array_push($collection, $row);
        }

        var_export($collection);
    }
}
