<?php declare(strict_types=1);

namespace Jtotty\CsvLoader;

use \SplFileObject;
use Port\Csv\CsvReader;
use Port\Steps\StepAggregator as Workflow;
use Port\Steps\Step\FilterStep;

class CsvLoader
{
    /**
     * Holds an instance of SplFileObject
     *
     * @var SplFileObject $file
     */
    private $file;

    /**
     * Holds an isntance of file contents as an associative array
     *
     * @var Array $contents
     */
    private $contents = [];

    /**
     * Holds an instance of the \Port\Csv\CsvReader
     *
     * @var \Port\Csv\CsvReader $reader
     */
    private $reader;

    /**
     * Holds an instanec of the \Port\Steps\StepAggregator
     *
     * @var \Port\Steps\StepAggregator $workflow
     */
    private $workflow;

    /**
     * Database columns
     *
     * @var Array $columns
     */
    private $columns = ['forename', 'surname', 'gender', 'dob', 'year', 'reg', 'eal', 'premium', 'meals', 'care'];

    /*
        sll_pupils:         'pupil_id', 'forename', 'surname', 'gender', 'dob'
        sll_pupils_import:             'forename', 'surname', 'gender', 'dob'
    */

    /**
     * Constructor method
     */
    public function __constructor()
    {
        // Code...
    }

    /**
     * Set the file to the SplFileObject
     *
     * @param  String $file_path
     * @return void
     */
    public function setFile(String $file_path)
    {
        // Set the file
        $this->file = new SplFileObject($file_path);

        // Add file to reader
        $this->reader = new CsvReader($this->file);
        $this->reader->setHeaderRowNumber(0, CsvReader::DUPLICATE_HEADERS_INCREMENT);

        // Iterate through contents - add to collection
        foreach ($this->reader as $row) {
            array_push($this->contents, $row);
        }

        // Initialise Workflow
        $this->workflow = new Workflow($this->reader);
    }

    /**
     * Returns the content of the csv file as array
     *
     * @return Array
     */
    public function getContents()
    {
        return $this->workflow;
    }

    /**
     * Returns the column headings from the uploaded csv
     *
     * @return Array
     */
    public function getColumnHeadings()
    {
        return $this->reader->getColumnHeaders();
    }

    /**
     *
     */
    public function testDob()
    {
        $step = new FilterStep();
        $step->add(function($input) {
            return $input['Gender'] !== 'M';
        });
    }

    /**
     * Maps the data from the source to the correct target columns
     *
     * @param Array $source_data
     * @param Array $target_data
     */
    public function mapColumnData(Array $source_data, Array $target_data)
    {

    }
}
