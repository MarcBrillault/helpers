<?php

namespace Embryo;

/**
 * Gives the depth of a given array
 * - 0 if empty
 * - 1 if single dimensional array
 * - 2 to x for every other depth
 *
 * Warning : this function will not work with recursive arrays
 *
 * @param array $array
 * @return int
 */
function arrayDepth(array $array)
{
    if (empty($array)) {
        return 0;
    }
    $maxDepth = 1;

    foreach ($array as $line) {
        if (is_array($line)) {
            $depth = arrayDepth($line) + 1;
            if ($depth > $maxDepth) {
                $maxDepth = $depth;
            }
        }
    }

    return $maxDepth;
}
