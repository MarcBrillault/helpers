<?php

require_once __DIR__ . '/../vendor/autoload.php';

$max  = 100000000;
$text = sprintf('looping %s times', number_format($max));

$start = time();
for ($i = 0; $i <= $max; $i++) {
    cliProgressBar($i, $max, 20, $text);
}
$end = time();

printf('Done in %d seconds', round($end - $start));

