<?php

require_once __DIR__ . '/../vendor/autoload.php';

$max = 10000;

for ($i = 0; $i <= $max; $i++) {
    cliSpinner('Counting to ' . $max);
}
cliSpinner('Done !', true);
