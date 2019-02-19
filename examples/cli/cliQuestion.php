<?php

namespace Embryo;

require_once __DIR__ . '/../../vendor/autoload.php';
cliClear();
$firstName = cliQuestion('What is your first name ?');
$lastName  = cliQuestion('What is your last name ?');

printf('Your name is %s %s' . PHP_EOL, $firstName, $lastName);