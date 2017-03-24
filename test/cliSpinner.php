<?php

require_once __DIR__ . '/../vendor/autoload.php';

$max = 10000000;

$start = time();
for ($i = 0; $i <= $max; $i++) {
    cliSpinner('Counting to ' . number_format($max));
}
cliSpinner('Done !', true);
$end = time();

printf('Done in %d seconds', round($end - $start));
