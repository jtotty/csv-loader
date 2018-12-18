<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files

use Jtotty\Sorter\Sorter;

$sorter = new Sorter();
$sorter->iterateCsv();