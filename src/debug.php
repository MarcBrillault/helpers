<?php

namespace Brio;

/**
 * var_dumps a var into <pre> tags
 *
 * @todo documenation
 * @param mixed $var
 * @return void
 */
function pp($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}