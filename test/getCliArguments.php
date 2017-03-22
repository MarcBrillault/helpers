<?php
require_once __DIR__ . '/../vendor/autoload.php';

// without parameters
$args = getCliArguments();
var_dump($args);

// with parameters
$params = [
    'productId',
    'verbose',
];
$args   = getCliArguments($params);
var_dump($args);