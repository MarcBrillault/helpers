<?php

namespace Brio;

require_once __DIR__ . '/../../vendor/autoload.php';

$str = <<<LIPSUM
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque condimentum lobortis risus. Ut quis ultrices sem.
Maecenas ultrices mauris non felis ultrices, sed scelerisque felis ullamcorper. Etiam at nulla eros. Duis in leo eget
lectus vulputate vestibulum. Nullam in quam non leo ornare condimentum. Vivamus eros quam, maximus vel ligula at,
elementum aliquet nisl. Vivamus lacinia viverra orci, fermentum volutpat mauris scelerisque at. Cras gravida posuere
vehicula. Aliquam ultrices tincidunt posuere. Cras sit amet facilisis est. Cras vel aliquam urna, eget aliquet mi.
LIPSUM;

echo strCut($str, 50, ' [...]') . PHP_EOL;
echo strCut($str, 50, ' [...]', true) . PHP_EOL;