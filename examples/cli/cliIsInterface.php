<?php
require_once __DIR__ . '/../../vendor/autoload.php';

\Embryo\cliClear();
if (\Embryo\cliIsInterface()) {
    echo 'We are on a command-line environment';
} else {
    echo 'We are NOT on a command-line environment';
}