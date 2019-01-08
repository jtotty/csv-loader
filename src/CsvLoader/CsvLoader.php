<?php

declare(strict_types=1);

namespace Jtotty\CsvLoader;

use Jtotty\Steps\CheckPupilDob;
use Jtotty\Steps\CheckPupilNames;
use Port\Csv\CsvReader;
use Port\Steps\Step\MappingStep;
use Port\Steps\Step\ValueConverterStep;
use Port\Steps\StepAggregator as Workflow;
use Port\ValueConverter\DateTimeValueConverter;
use Port\Writer\ArrayWriter;

class CsvLoader
{
    /**
     * Holds an instance of SplFileObject.
     *
     * @var SplFileObject
     */
    private $file;

    /**
     * Holds an isntance of file contents as an associative array.
     *
     * @var array
     */
    private $contents = [];

    /**
     * Holds an instance of the column name mappings.
     *
     * @var array
     */
    private $columnMap;

    /**
     * Holds an instance of the \Port\Csv\CsvReader.
     *
     * @var \Port\Csv\CsvReader
     */
    private $reader;

    /**
     * Holds an instanec of the \Port\Steps\StepAggregator.
     *
     * @var \Port\Steps\StepAggregator
     */
    private $workflow;

    /**
     * Constructor method.
     */
    public function __constructor()
    {
    }

    /**
     * Load the file to the SplFileObject.
     *
     * @return void
     */
    public function loadFile(String $file_path)
    {
        // Set the file
        $this->file = new \SplFileObject($file_path);

        // Add file to reader
        $this->reader = new CsvReader($this->file);
        $this->reader->setHeaderRowNumber(0, CsvReader::DUPLICATE_HEADERS_INCREMENT);

        // Initialise the workflow!!
        $this->createWorkFlow();
    }

    /**
     * Starts the workflow to process the array data.
     *
     * @return void
     */
    public function createWorkFlow()
    {
        // Initialise Workflow
        $this->workflow = new Workflow($this->reader);

        // The modified array data will be saved to `$this->contents`
        $writer = new ArrayWriter($this->contents);
        $this->workflow->addWriter($writer);
    }

    /**
     * Returns the number of data rows.
     *
     * @return Integer
     */
    public function getDataCount()
    {
        return $this->reader->count();
    }

    /**
     * Returns the column headings from the uploaded csv.
     *
     * @return Array
     */
    public function getColumnHeadings()
    {
        return $this->reader->getColumnHeaders();
    }

    /**
     * Run the workflow.
     *
     * @return void
     */
    public function processData()
    {
        $this->workflow->process();
    }

    /**
     * Sets the data column mapping array.
     *
     * @return void
     */
    public function setColumnMap(array $columnMap)
    {
        $this->columnMap = $columnMap;
    }

    /**
     * Renames the column names according to the map.
     *
     * @return void
     */
    public function mapColumnNamesStep()
    {
        // Create a mapping step
        $mappingStep = new MappingStep();

        // Iterate through the column names that need changing
        foreach ($this->columnMap as $key => $value) {
            $mappingStep->map('[' . $key . ']', '[' . $value . ']');
        }

        // Add to the workflow
        $this->workflow->addStep($mappingStep);
    }

    /**
     * Converts date of birth to correct format.
     *
     * @return void
     */
    public function convertDobStep()
    {
        // Format the dob string so we can convert it correctly
        $checkDobStep = new CheckPupilDob();
        $this->workflow->addStep($checkDobStep);

        // Convert from input format to output
        $dateTimeConverter = new DateTimeValueConverter(null, 'Y-m-d');
        $converterStep     = new ValueConverterStep();
        $converterStep->add('[DOB]', $dateTimeConverter);

        $this->workflow->addStep($converterStep);
    }

    /**
     * Very specific method to check if a user has entered
     * the entire pupil's name into one column (Either forename or surname).
     *
     * @return array $contents
     */
    public function checkPupilNamesStep()
    {
        $checkNamesStep = new CheckPupilNames();
        $this->workflow->addStep($checkNamesStep);
    }

    /**
     * Returns the content of the csv file as array.
     *
     * @return Array
     */
    public function getProcessedContents()
    {
        return $this->contents;
    }
}
