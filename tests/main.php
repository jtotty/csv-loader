<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\CsvLoader\CsvLoader;

// Load CSV File
$csvLoader = new CsvLoader();
$csvLoader->loadFile('files/five_pupils_test.csv');

// Array Map
$mapping = [
    'English as additional language' => 'EAL',
    'Pupil Premium Indicator'        => 'Pupil Premium',
    'Eligible for free meals'        => 'Free Meals',
    'Ever in care'                   => 'Care',
];

$optionalColumns = ['EAL', 'Pupil Premium', 'Free Meals', 'Care'];

// Set the names of the columns we want to change
$csvLoader->setColumnMap($mapping);

// Steps
$csvLoader->mapColumnNamesStep();
$csvLoader->checkPupilNamesStep();
$csvLoader->checkPupilGenderStep();
$csvLoader->convertDobStep();
$csvLoader->checkGroupOptionValuesStep($optionalColumns);

// Process
$csvLoader->processData();

// Debugging
var_export($csvLoader->getProcessedContents());
