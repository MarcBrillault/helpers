<?php

namespace Brio;

/**
 * Transforms a string into something usable as an URL
 *
 * All the characters will be lowered, accents will be discarded
 * Non-alphanumeric characters will be changed to hyphens
 *
 * @param string $str
 * @return string
 */
function seoUrl($str)
{
    $str = preg_replace('#[^\\p{L}\d]+#u', '-', $str);
    $str = trim($str, '-');
    $str = iconv(mb_detect_encoding($str), 'us-ascii//TRANSLIT', $str);
    $str = strtolower($str);
    $str = preg_replace('#[^-\w]+#', '', $str);

    return $str;
}