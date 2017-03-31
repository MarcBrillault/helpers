<?php

require_once __DIR__ . '/../../vendor/autoload.php';

/*
 * Comment the lines you don't want to test, since dd() dies
 */

$test = [
    'var'       => 1,
    'secondVar' => true,
];

// Should dump $test as a JSON
\Brio\dd($test);

// Should var_dump $test
\Brio\d($test);

// Should dump $test as a JSON, only if $_GET['test'] or $_POST['test'] are equivalent to true
\Brio\dd($test, 'test');

// Should var_dump $test, since something has already been displayed
echo 'test';
\Brio\dd($test);