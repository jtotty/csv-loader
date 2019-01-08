<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\CsvLoader\CsvLoader;

// Load CSV File
$csvLoader = new CsvLoader();
$csvLoader->loadFile('files/csv_file.csv');

// Array Map
$mapping = [
    'English as additional language' => 'eal',
    'Pupil Premium Indicator'        => 'premium',
    'Eligible for free meals'        => 'meals',
    'Ever in care'                   => 'care',
];

// Set the names of the columns we want to change
$csvLoader->setColumnMap($mapping);

// Steps
$csvLoader->mapColumnNamesStep();
$csvLoader->checkPupilNamesStep();
$csvLoader->convertDobStep();

// Process
$csvLoader->processData();

// Debugging
var_export($csvLoader->getProcessedContents());
var_export($csvLoader->getDataCount());
