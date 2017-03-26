<?php

namespace Brio;

require_once __DIR__ . '/../../vendor/autoload.php';

$table = [
    [
        'id'    => 1,
        'name'  => 'John Doe',
        'email' => 'john@doe.com',
    ],
    [
        'id'    => 2,
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ],
    [
        'id'    => 3,
        'name'  => 'Alfred E. Neuman',
        'email' => 'whatmeworry@madmagazine.com',
    ],
];

echo cliTable($table);