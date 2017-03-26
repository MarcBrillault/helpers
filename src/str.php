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