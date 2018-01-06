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

/**
 * Performs a reverted parse_url
 *
 * @param array $url
 * @return string
 */
function unparseUrl(array $url)
{
    $possibleKeys = [
        'scheme',
        'host',
        'port',
        'user',
        'pass',
        'path',
        'query',
        'fragment',
    ];

    $possibleKeysToEncode = [
        'user',
        'pass',
        'host',
    ];

    // Encoding
    foreach ($possibleKeys as $possibleKey) {
        if (in_array($possibleKey, $possibleKeysToEncode) && array_key_exists($possibleKey, $url)) {
            $url[$possibleKey] = rawurlencode($url[$possibleKey]);
        }
    }

    $return = '';

    // Scheme
    if (isset($url['scheme'])) {
        $return .= $url['scheme'] . '://';
    }

    // Credentials
    if (isset($url['user'])) {
        $return .= $url['user'];

        if (isset($url['pass'])) {
            $return .= ':' . $url['pass'];
        }

        $return .= '@';
    }

    // Host
    if (isset($url['host'])) {
        $return .= $url['host'];
    }

    // Port
    if (isset($url['port']) && is_numeric($url['port'])) {
        $return .= ':' . $url['port'];
    }

    // Path
    if (isset($url['path'])) {
        $return .= $url['path'];
    }

    // Query
    if (isset($url['query'])) {
        if (is_array($url['query'])) {
            $url['query'] = http_build_query($url['query']);
        }

        $return .= '?' . $url['query'];
    }

    // Anchor
    if (isset($url['fragment'])) {
        $return .= '#' . $url['fragment'];
    }

    return $return;
}