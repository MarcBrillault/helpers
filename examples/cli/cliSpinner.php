<?php

namespace Embryo;

require_once __DIR__ . '/../../vendor/autoload.php';

cliClear();
$max  = 10000000;
$text = sprintf('Looping %s times', number_format($max));

$start = time();
for ($i = 0; $i <= $max; $i++) {
    cliSpinner($text);
}
cliSpinner('Done !', true);
$end = time();

printf('Done in %d seconds', round($end - $start));
