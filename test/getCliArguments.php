<?php
require_once __DIR__ . '/../vendor/autoload.php';

// without parameters
$args = getCliArguments();
var_dump($args);

// with simple parameters
// $params = [
//     'p',
//     'v',
// ];
// $args   = getCliArguments($params);
// var_dump($args);

// with complex parameters
$params = [
    'p' => 'product',
    'v' => 'verbose',
];
$args   = getCliArguments($params);
var_dump($args);