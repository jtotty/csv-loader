<?php

use Jtotty\CsvLoader\CsvLoader;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    protected $csvLoader;
    protected $contents;

    public function setUp()
    {
        $this->csvLoader = new CsvLoader();
        $this->csvLoader->loadFile('files/stjosephSA12-import-test.csv');

        // Array Map
        $mapping = [
            'Preferred Forename'             => 'Forename',
            'Preferred Surname'              => 'Surname',
            'Date of Birth'                  => 'DOB',
            'Year Group'                     => 'Year',
            'Reg Group'                      => 'Tutor',
            'English as additional language' => 'EAL',
            'SEN Status'                     => 'SEN Status', // remove this column
        ];

        $optionalColumns = [
            'EAL',
            'Pupil Premium / Pupil Deprivation Grant',
            'Free School Meals',
            'Looked-After Children',
            'Outside Agency Involvement',
        ];

        // Set the names of the columns we want to change
        $this->csvLoader->setColumnMap($mapping);

        // Add the optional steps
        $this->csvLoader->removeEmptyRowsStep();
        $this->csvLoader->mapColumnNamesStep();
        $this->csvLoader->checkPupilNamesStep();
        $this->csvLoader->checkPupilGenderStep();
        $this->csvLoader->convertDobStep();
        $this->csvLoader->checkGroupOptionValuesStep($optionalColumns);

        // Process
        $this->csvLoader->processData();

        $this->contents = $this->csvLoader->getProcessedContents();
    }

    /** @test */
    public function processed_data_has_no_empty_rows()
    {
        foreach ($this->contents as $pupil_attributes) {
            $count = 0;
            foreach ($pupil_attributes as $attribute) {
                if (empty($attribute)) {
                    ++$count;
                }
            }

            $this->assertTrue($count < 4);
        }
    }

    /** @test */
    public function pupil_has_valid_forename_and_surname()
    {
        foreach ($this->contents as $pupil_attributes) {
            $forename = $pupil_attributes['Forename'];
            $surname  = $pupil_attributes['Surname'];

            // RegExp: No whitespace at beginning or end, only characters "a-z", "A-Z", "-", and "'"
            $this->assertRegExp('/^[\SA-Z][a-zA-Z0-9\s-\']+[\S]$/', $forename);
            $this->assertRegExp('/^[\SA-Z][a-zA-Z0-9\s-\']+[\S]$/', $surname);
        }
    }

    /** @test */
    public function pupil_gender_is_valid()
    {
        foreach ($this->contents as $pupil_attributes) {
            $gender = $pupil_attributes['Gender'];

            $this->assertIsString($gender);
            $this->assertTrue($gender === 'F' || $gender === 'M');
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
    public function optional_group_value_is_t_or_f()
    {
        foreach ($this->contents as $pupil_attributes) {
            $attributes_to_test = array_splice($pupil_attributes, 6);

            foreach ($attributes_to_test as $attribute) {
                $this->assertTrue($attribute === 'T' || $attribute === 'F' || $attribute === 'invalid');
            }
        }
    }

    /** @test */
    public function able_to_write_data_to_csv_file()
    {
        $filePath = './files/invalid_pupils.csv';
        $this->csvLoader->writeToCsv($this->contents, $filePath);
        $this->assertFileExists($filePath);
        $this->assertIsReadable($filePath);
    }
}
