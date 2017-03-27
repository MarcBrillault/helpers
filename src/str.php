<?php

namespace Brio;

/**
 * Limits the size of a given string
 *
 * @todo don't cut in between words on a long text
 * @todo define "long text"
 * @param string $str           Text to cut if too long
 * @param int    $length        Maximum length of returned text
 * @param string $end           Text to be displayed at the end of the string to indicate it has been cut
 * @param bool   $isTotalLength If set to true, total length returned (including $end) will not exceed $length
 * @return string
 */
function strCut($str, $length = 200, $end = '…', $isTotalLength = false)
{
    if (mb_strlen($str) <= $length || !$length) {
        return $str;
    }

    if ($isTotalLength) {
        $length = $length - mb_strlen($end);
    }

    $str = mb_substr($str, 0, $length);

    return $str . $end;
}

/**
 * Tells whether a string is encoded in UTF-8
 *
 * @todo documentation
 * @todo test
 * @param string $str
 * @return bool
 */
function strIsUtf8($str)
{
    return mb_detect_encoding($str, ['UTF-8'], true);
}

/**
 * Completes a text to match a given length
 *
 * If the text is larger than $length, it will be returned unaltered
 *
 * @todo documentation
 * @param string $str
 * @param int    $length
 * @param string $fill
 * @param bool   $fillFromLeft
 * @return string
 */
function strComplete($str, $length, $fill = ' ', $fillFromLeft = false)
{
    $fillLength = $length - mb_strlen($str);
    if (!$fillLength) {
        return $str;
    }
    $fillText = str_repeat($fill, $fillLength);

    if ($fillFromLeft) {
        return $fillText . $str;
    }

    return $str . $fillText;
}