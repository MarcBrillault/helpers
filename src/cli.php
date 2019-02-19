<?php

namespace Embryo;

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
 * Clears the cli screen. Works in Windows and Unix environments.
 *
 * @see https://stackoverflow.com/questions/24327544/how-can-clear-screen-in-php-cli-like-cls-command/37853460#37853460
 */
function cliClear()
{
    echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
}

/**
 * Returns true if the current script is called via command line
 *
 * @return bool
 */
function cliIsInterface()
{
    return substr(php_sapi_name(), 0, 3) === 'cli';
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
 * Asks a question to the user and returns true or false depending on the answer
 *
 * @param string $question
 * @param array  $answers Index 0 is the answer needed to return true
 * @return bool
 */
function cliPrompt($question, array $answers = [])
{
    if (count($answers) < 1) {
        $answers = ['yes', 'no'];
    }

    $stringAnswers   = '';
    $possibleAnswers = [];

    foreach ($answers as $answerKey => $answer) {
        $stringAnswers .= preg_replace('#^(.)(.*)$#', '[$1]$2', $answer);

        if ($answerKey === 0) {
            if (count($answers) > 1) {
                $stringAnswers .= ' / ';
            }
            $possibleAnswers[] = mb_strtolower($answer);
            $possibleAnswers[] = substr(mb_strtolower($answer), 0, 1);
        }
    }

    $userInput = cliQuestion($question . ' ' . $stringAnswers);

    if (!in_array($userInput, $possibleAnswers)) {
        return false;
    }

    return true;
}

/**
 * Asks a question to the user, and returns its answer as a string
 *
 * @param string $question
 * @return string
 */
function cliQuestion($question)
{
    echo $question . PHP_EOL;

    $handle = fopen("php://stdin", "r");

    return trim(fgets($handle));
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

/**
 * Display a cli-compatible table from an array
 *
 * @param array $table       The data to display.
 * @param int   $maxColWidth All content length superior than the value will be truncated
 * @return string
 */
function cliTable(array $table, $maxColWidth = 20)
{
    $return = '';

    if (empty($table)) {
        return $return;
    }

    $keys = [];
    foreach ($table as $line) {
        foreach ($line as $key => $value) {
            if (!array_key_exists($key, $keys)) {
                $keys[$key] = [
                    'name'   => $key,
                    'length' => mb_strlen($key),
                ];
            }
        }
    }

    // Maximum lengths
    foreach ($table as $tableKey => $line) {
        foreach ($line as $key => $value) {
            // Transformation of values
            $type = gettype($value);
            switch ($type) {
                case 'boolean':
                    $value = ($value) ? 'true' : 'false';
                    break;
                case 'array':
                case 'resource':
                    $value = ucfirst($type);
                    break;
                case 'object':
                    $value = sprintf('%s object', get_class($value));
                    break;
                case 'integer':
                    $value = number_format($value);
                    break;
                case 'double':
                    $value = number_format($value, 2);
                    break;
            }

            // Max col width
            $value                  = strCut($value, $maxColWidth, '…', true);
            $table[$tableKey][$key] = $value;

            $length = mb_strlen($value);
            if ($keys[$key]['length'] < $length) {
                $keys[$key]['length'] = $length;
            }
        }
    }

    // First line display
    $border    = [];
    $delimiter = [];
    foreach ($keys as $key) {
        $border[]    = str_repeat('═', $key['length'] + 2);
        $delimiter[] = str_repeat('─', $key['length'] + 2);
    }
    $return .= sprintf('╔%s╗' . PHP_EOL, implode('╤', $border));

    // header display
    $header = [];
    foreach ($keys as $key) {
        $header[] = strComplete(' ' . $key['name'], $key['length'] + 2);
    }
    $return .= sprintf('║%s║' . PHP_EOL, implode('│', $header));

    // content display
    foreach ($table as $key => $line) {
        if (!$key) {
            // separator
            $return .= sprintf('╟%s╢' . PHP_EOL, implode('┼', $delimiter));
        }

        $content = [];
        foreach ($keys as $keyName => $keyData) {
            if (array_key_exists($keyName, $line)) {
                $cellContents = $line[$keyName];
            } else {
                $cellContents = '';
            }
            if (is_numeric($cellContents)) {
                $content[] = strComplete($cellContents . ' ', $keys[$keyName]['length'] + 2, ' ', true);
            } else {
                $content[] = strComplete(' ' . $cellContents, $keys[$keyName]['length'] + 2);
            }
        }

        $return .= sprintf('║%s║' . PHP_EOL, implode('│', $content));
    }

    // Last line display
    $return .= sprintf('╚%s╝' . PHP_EOL, implode('╧', $border));

    return $return;
}