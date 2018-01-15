<?php

namespace Brio;

require_once __DIR__ . '/../../vendor/autoload.php';

echo 'Example with same keys everywhere:' . PHP_EOL;

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

echo 'Example with Arrays, objects, etc:' . PHP_EOL;
$table = [
    [
        'type'  => 'string',
        'value' => 'test',
    ],
    [
        'type'  => 'array',
        'value' => [],
    ],
    [
        'type'  => 'object',
        'value' => new \stdClass(),
    ],
    [
        'type'  => 'integer',
        'value' => 42,
    ],
    [
        'type'  => 'float',
        'value' => pi(),
    ],
];

echo cliTable($table);

echo 'Example with different keys:' . PHP_EOL;

$table = [
    [
        'id'       => 1,
        'name'     => 'John Doe',
        'email'    => 'john@doe.com',
        'Location' => 'Unknown',
    ],
    [
        'id'    => 2,
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ],
    [
        'id'       => 3,
        'name'     => 'Alfred E. Neuman',
        'email'    => 'whatmeworry@madmagazine.com',
        'magazine' => 'Mad Magazine',
    ],
];
echo cliTable($table);