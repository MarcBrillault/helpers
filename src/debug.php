<?php

namespace Brio;

/**
 * dump
 * Dumps the given data.
 * The dump can also be linked to a given _REQUEST parameter
 *
 * @param  mixed  $var
 * @param  string $request If set, will only execute if the corresponding $_GET key exists and is not empty
 * @param  bool   $die     If true (Called via \Brio\dd()), will transform objects and arrays to JSON, if available
 *                         (not CLI, no previous output)
 * @return bool   has a var_dump occurred ?
 */
function d($var, $request = null, $die = false)
{
    if (!$request || (isset($_REQUEST[$request]) && $_REQUEST[$request])) {
        if ($die && (is_array($var) || is_object($var)) && !cliIsInterface()) {
            if (!headers_sent() && !ob_get_contents()) {
                // ob_get_contents because of eventual output_buffering
                header('Content-Type: application/json');
                $var = json_encode($var);
            }
        }
        if (strIsJson($var)) {
            echo $var;
        } else {
            var_dump($var);
        }

        return true;
    }

    return false;
}

/**
 * dump & die
 * Loads d with the given values, then dies
 *
 * @see  \Brio\d()
 *
 * @param  mixed  $var
 * @param  string $request If set, will only execute if the corresponding $_REQUEST key exists and is not empty
 *
 * @return void
 */
function dd($var, $request = null)
{
    if (d($var, $request, true)) {
        die();
    }
}

/**
 * var_dumps a var into <pre> tags
 *
 * @param mixed $var
 * @return void
 */
function pp($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}