<?php

namespace Brio;

/**
 * Returns an array with the script's arguments
 *
 * @param array $allowedArgs         List of allowed arguments, if any
 * @param bool  $dieOnEmptyArguments If set to true, the script will die if it is called with no argument
 * @return array
 */
function cliArguments(array $allowedArgs = [], $dieOnEmptyArguments = false)
{
    $return      = [];
    $regArgument = '/^-[\w]+$/';
    global $argv;
    unset($argv[0]);
    try {
        if (empty($argv) && $dieOnEmptyArguments) {
            throw new \Exception('There should be at least one argument');
        }

        $previousArg = null;
        foreach ($argv as $arg) {
            if (preg_match($regArgument, $arg)) {
                // New argument detected
                $currentArg = trim($arg, '-');
                if (!empty($allowedArgs) && !in_array($currentArg, $allowedArgs)) {
                    // Error if the given argument is not whitelisted
                    throw new \Exception(sprintf('Argument not allowed : %s', $currentArg));
                }
                // New argument's default value is always true
                $return[$currentArg] = true;
                $previousArg         = $currentArg;
            } else {
                if ($previousArg) {
                    $return[$previousArg] = $arg;
                    $previousArg          = null;
                } else {
                    // two values cannot follow each other
                    throw new \Exception(sprintf('wrong argument : %s', $arg));
                }
            }
        }
    } catch (\Exception $e) {
        $errorMessage = $e->getMessage() . PHP_EOL;
        if (!empty($allowedArgs)) {
            // If $allowedArgs is set, an error triggers the manual
            $errorMessage .= 'Allowed arguments are :' . PHP_EOL;
            foreach ($allowedArgs as $key => $value) {
                $errorMessage .= sprintf("\t-%s" . PHP_EOL, $value);
            }
        }
        die($errorMessage);
    }

    return $return;
}

/**
 * Displays a progressbar
 *
 * @param int    $current The current index
 * @param int    $total   The total count
 * @param int    $length  Progress bar's length in characters
 * @param string $text    Text to display before the spinner
 * @param string $endText Text to display when the progress has ended
 */
function cliProgressBar($current, $total, $length = 10, $text = 'In progress...', $endText = 'Done !')
{
    $numberOfBars = floor($length * $current / $total);

    if (!isset($GLOBALS['cliProgressBarNumber']) || $numberOfBars != $GLOBALS['cliProgressBarNumber']) {
        printf('%s%s %s', chr(13), $text, sprintf('[%-' . $length . 's]', str_repeat('=', $numberOfBars)));
        $GLOBALS['cliProgressBarNumber'] = $numberOfBars;
    }

    if ($current == $total) {
        unset($GLOBALS['cliProgressBarNumber']);
        echo ' ' . $endText . PHP_EOL;
    }
}

/**
 * Displays a spinner, advancing each time it is called
 *
 * @param string $message The message to display
 * @param bool   $end     If set to true, will display the message and end the spinner
 */
function cliSpinner($message = 'Performing action', $end = false)
{
    $phases = [
        '\\',
        '|',
        '/',
        '—',
    ];

    $timeBetweenSpins = 500; // In microseconds

    if (!isset($GLOBALS['cliSpinnerIndex']) || $GLOBALS['cliSpinnerIndex'] >= count($phases)) {
        $GLOBALS['cliSpinnerIndex'] = 0;
    }

    if (isset($GLOBALS['cliSpinnerTime'])) {
        $lastTime = $GLOBALS['cliSpinnerTime'];
    } else {
        $lastTime = 0;
    }

    if (!$end) {
        $currentTime = microtime(true);
        if ($currentTime > ($lastTime + ($timeBetweenSpins / 10000))) {
            printf('%s%s %s ', chr(13), $message, $phases[$GLOBALS['cliSpinnerIndex']]);
            $GLOBALS['cliSpinnerIndex']++;
            $GLOBALS['cliSpinnerTime'] = $currentTime;
        }
    } else {
        printf('%s%s' . PHP_EOL, chr(8) . chr(8), $message);
        unset($GLOBALS['cliSpinnerIndex']);
        unset($GLOBALS['cliSpinnerTime']);
    }
}