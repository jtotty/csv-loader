<?php

use Jtotty\CsvLoader\CsvLoader;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    /**
     * Holds an instance of the Jtotty\CsvLoader\CsvLoader.
     */
    protected $csvLoader;

    public function setUp()
    {
        $this->csvLoader = new CsvLoader();
        $this->csvLoader->loadFile('files/csv_file.csv');

        // Array Map
        $mapping = [
            'English as additional language' => 'eal',
            'Pupil Premium Indicator'        => 'premium',
            'Eligible for free meals'        => 'meals',
            'Ever in care'                   => 'care',
        ];

        // Set the names of the columns we want to change
        $this->csvLoader->setColumnMap($mapping);

        // Add the optional steps
        $this->csvLoader->mapColumnNamesStep();
        $this->csvLoader->checkPupilNamesStep();
        $this->csvLoader->convertDobStep();

        // Process
        $this->csvLoader->processData();
    }

    /** @test */
    public function dob_has_been_converted()
    {
        $contents = $this->csvLoader->getContents();

        foreach ($contents as $pupil_attributes) {
            $d = DateTime::createFromFormat('Y-m-d', $pupil_attributes['DOB']);
            $this->assertEquals($pupil_attributes['DOB'], $d->format('Y-m-d'));
        }
    }
}
