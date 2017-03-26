<?php

namespace Brio;

require_once __DIR__ . '/../../vendor/autoload.php';

$max  = 100000000;
$text = sprintf('Looping %s times', number_format($max));

$start = time();
for ($i = 0; $i <= $max; $i++) {
    cliSpinner($text);
}
cliSpinner('Done !', true);
$end = time();

printf('Done in %d seconds', round($end - $start));
