<?php

namespace Brio;

/**
 * Completes a text to match a given length
 *
 * If the text is larger than $length, it will be returned unaltered
 *
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

    $fillText = '';
    if ($fillLength > 0) {
        $fillText = str_repeat($fill, $fillLength);
    }

    if ($fillFromLeft) {
        return $fillText . $str;
    }

    return $str . $fillText;
}

/**
 * Limits the size of a given string
 *
 * @param string $str           Text to cut if too long
 * @param int    $length        Maximum length of returned text
 * @param string $end           Text to be displayed at the end of the string to indicate it has been cut
 * @param bool   $isTotalLength If set to true, total length returned (including $end) will not exceed $length
 * @return string
 */
function strCut($str, $length = 200, $end = '…', $isTotalLength = false)
{
    if (mb_strlen($str) <= $length || $length <= 0) {
        return $str;
    }

    if ($isTotalLength) {
        $length = $length - mb_strlen($end);
    }

    $str = mb_substr($str, 0, $length);

    if ($length >= 40) {
        $str = mb_substr($str, 0, strrpos($str, ' '));
    }

    // We delete the commas, hyphens and underscores if they are in last position
    $str = preg_replace('/([,;_-]+)$/', '', $str);

    return $str . $end;
}

/**
 * Tests if a given string is valid JSON
 *
 * @param  mixed $str
 * @return bool
 */
function strIsJson($str)
{
    if (!is_string($str)) {
        return false;
    }
    json_decode($str);

    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * Returns whether the given string contains valid XML code (including HTML)
 *
 * @param  string $str
 * @return bool
 */
function strIsXml($str)
{
    return strlen($str) != strlen(strip_tags($str));
}

/**
 * Tells whether a string is encoded in UTF-8
 *
 * @author chris@w3style.co.uk
 * @see    http://php.net/manual/fr/function.mb-detect-encoding.php#68607
 *
 * @param string $str
 * @return bool
 */
function strIsUtf8($str)
{
    return (bool) preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]              # non-overlong 2-byte
        |\xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
        |\xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
        |\xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
        |[\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
        |\xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
        )+%xs', $str);
}