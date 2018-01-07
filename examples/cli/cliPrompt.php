<?php

namespace Brio;

require_once __DIR__ . '/../../vendor/autoload.php';

// Default answers
if (cliPrompt('Annie, are you okay ?')) {
    echo 'He came in your apartment.' . PHP_EOL;
} else {
    echo 'You\'ve been hit by ... A smooth criminal.' . PHP_EOL;
}

// Two answers
if (cliPrompt('Do you want to continue ?', ['continue', 'abort'])) {
    echo 'continuing...' . PHP_EOL;
} else {
    echo 'aborting.' . PHP_EOL;
}

// Only one answer
if (cliPrompt('Do you really want to continue ?', ['yes, of course'])) {
    echo 'ok then';
} else {
    echo 'Bye !';
}

