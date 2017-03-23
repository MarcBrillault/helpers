<?php
require_once __DIR__ . '/../vendor/autoload.php';

// without parameters
$args = cliArguments();
var_dump($args);

// with parameters
$params = [
    'productId',
    'verbose',
];
$args   = cliArguments($params);
var_dump($args);