<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\CsvLoader\CsvLoader;

$csvLoader = new CsvLoader();
$csvLoader->setFile('files/csv_file.csv');
