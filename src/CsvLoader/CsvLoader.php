<?php declare(strict_types=1);

namespace Jtotty\CsvLoader;

use \SplFileObject;

use Port\Csv\CsvReader;

use Port\Writer\ArrayWriter;

use Port\Steps\Step\FilterStep;
use Port\Steps\Step\MappingStep;
use Port\Steps\Step\ConverterStep;
use Port\Steps\Step\ValueConverterStep;
use Port\Steps\StepAggregator as Workflow;

use Jtotty\Steps\CheckPupilNames;

use Port\ValueConverter\DateTimeValueConverter;

/**
 * @author James Totty <jtotty1991@gmail.com>
 */
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
     * Holds an instance of the column name mappings
     *
     * @var Array $columnMap
     */
    private $columnMap;

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
     * Constructor method
     */
    public function __constructor()
    {
        // Code...
    }

    /**
     * Load the file to the SplFileObject
     *
     * @param  String $file_path
     * @return void
     */
    public function loadFile(String $file_path)
    {
        // Set the file
        $this->file = new SplFileObject($file_path);

        // Add file to reader
        $this->reader = new CsvReader($this->file);
        $this->reader->setHeaderRowNumber(0, CsvReader::DUPLICATE_HEADERS_INCREMENT);

        // Initialise the workflow!!
        $this->createWorkFlow();
    }

    /**
     * Starts the workflow to process the array data
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
     * Returns the content of the csv file as array
     *
     * @return Array
     */
    public function getContents()
    {
        return $this->contents;
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
     * Run the workflow
     *
     * @return void
     */
    public function processData()
    {
        $this->workflow->process();
    }

    /**
     * Sets the data column mapping array
     *
     * @return void
     */
    public function setColumnMap(Array $columnMap)
    {
        $this->columnMap = $columnMap;
    }

    /**
     * Renames the column names according to the map
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
     * Converts date of birth to correct format
     *
     * @return void
     */
    public function convertDobStep()
    {
        // Convert from input format to output
        $dateTimeConverter = new DateTimeValueConverter(null, 'Y-m-d');
        $converterStep     = new ValueConverterStep();
        $converterStep->add('[DOB]', $dateTimeConverter);

        // Add to the workflow
        $this->workflow->addStep($converterStep);
    }

    /**
     * Very specific method to check if a user has entered
     * the entire pupil's name into one column (Either forename or surname).
     *
     * @param  Array $contents
     * @return Array $contents
     */
    public function checkPupilNamesStep()
    {
        $checkNamesStep = new CheckPupilNames();
        $this->workflow->addStep($checkNamesStep);
    }
}
