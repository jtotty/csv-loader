<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\CsvLoader\CsvLoader;

// Load CSV File
$csvLoader = new CsvLoader();
$csvLoader->loadFile('files/csv_file.csv');

// Steps
$csvLoader->checkPupilNames();
$csvLoader->convertDob();
$csvLoader->mapColumnNames();

// Process
$csvLoader->processData();

// Debugging
var_export($csvLoader->getContents());
