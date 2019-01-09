<?php

use Jtotty\CsvLoader\CsvLoader;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    /**
     * Holds an instance of the Jtotty\CsvLoader\CsvLoader.
     */
    protected $csvLoader;

    protected $contents;

    public function setUp()
    {
        $this->csvLoader = new CsvLoader();
        $this->csvLoader->loadFile('files/csv_file_2.csv');

        // Array Map
        $mapping = [
            'English as additional language' => 'EAL',
            'Pupil Premium Indicator'        => 'Pupil Premium',
            'Eligible for free meals'        => 'Free Meals',
            'Ever in care'                   => 'Care',
        ];

        // Set the names of the columns we want to change
        $this->csvLoader->setColumnMap($mapping);

        // Add the optional steps
        $this->csvLoader->mapColumnNamesStep();
        $this->csvLoader->checkPupilNamesStep();
        $this->csvLoader->convertDobStep();
        $this->csvLoader->convertGroupTypesToBoolean();

        // Process
        $this->csvLoader->processData();

        $this->contents = $this->csvLoader->getProcessedContents();
    }

    /** @test */
    public function pupil_has_valid_forename_and_surname()
    {
        foreach ($this->contents as $pupil_attributes) {
            $forename = $pupil_attributes['Forename'];
            $surname  = $pupil_attributes['Surname'];

            // RegExp: No whitespace at beginning or end, only characters "a-z", "A-Z", "-", and "'"
            $this->assertRegExp('/^[\S][a-zA-Z0-9\s-\']+[\S]$/', $forename);
            $this->assertRegExp('/^[\S][a-zA-Z0-9\s-\']+[\S]$/', $surname);
        }
    }

    /** @test */
    public function dob_has_been_converted()
    {
        foreach ($this->contents as $pupil_attributes) {
            $d = DateTime::createFromFormat('Y-m-d', $pupil_attributes['DOB']);
            $this->assertEquals($pupil_attributes['DOB'], $d->format('Y-m-d'));
        }
    }

    /** @test */
    public function group_value_true_or_false()
    {
        foreach ($this->contents as $pupil_attributes) {
            $this->assertIsBool($pupil_attributes['EAL']);
        }
    }
}
