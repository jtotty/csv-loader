<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\CsvLoader\CsvLoader;

// Load CSV File
$csvLoader = new CsvLoader();
$csvLoader->loadFile('files/stjosephSA12-import-test.csv');

// Array Map
$mapping = [
    'Preferred Forename'             => 'Forename',
    'Preferred Surname'              => 'Surname',
    'Date of Birth'                  => 'DOB',
    'Year Group'                     => 'Year',
    'Reg Group'                      => 'Tutor',
    'English as additional language' => 'EAL',
];

$optionalColumns = [
    'EAL',
    'Pupil Premium / Pupil Deprivation Grant',
    'Free School Meals',
    'Looked-After Children',
    'Outside Agency Involvement',
];

// Set the names of the columns we want to change
$csvLoader->setColumnMap($mapping);

// Steps
$csvLoader->removeEmptyRowsStep();
$csvLoader->mapColumnNamesStep();
$csvLoader->checkPupilNamesStep();
$csvLoader->checkPupilGenderStep();
$csvLoader->convertDobStep();
$csvLoader->checkGroupOptionValuesStep($optionalColumns);

// Process
$csvLoader->processData();

// Debugging
var_export($csvLoader->getProcessedContents());
