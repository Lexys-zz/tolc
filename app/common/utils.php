<?php

/**
 * @param $date_string
 * @param $format_string
 * @param $timezone_string
 * @return string
 */
function date_string_format($date_string, $format_string, $timezone_string) {
    $tz = new DateTimeZone($timezone_string);
    $date = new DateTime($date_string);
    $date->setTimeZone($tz);
    return $date->format($format_string);
}

/**
 * @param string $format_string
 * @param string $str_timezone
 * @return string
 */
function now($format_string = CONST_PREF_DATE_FORMAT_TIMESTAMP_FULL, $str_timezone = CONST_DEFAULT_TIMEZONE) {
    return date_string_format('', $format_string, $str_timezone);
}

/**
 * Converts a 14-digit timestamp to date string
 * @param $ts
 * @param string $format
 * @param string $str_timezone
 * @return string
 */
function date_decode($ts, $format = CONST_PREF_DATE_FORMAT_DATETIME, $str_timezone = CONST_DEFAULT_TIMEZONE) {
    $tz = new DateTimeZone($str_timezone);
    $date = new DateTime($ts);
    $date->setTimeZone($tz);
    return $date->format($format);
}

/**
 * Timezones list with GMT offset
 * http://stackoverflow.com/a/9328760
 * @return array
 */
function tz_list() {
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
    }
    return $zones_array;
}


/**
 * http://stackoverflow.com/a/3615890
 * @param $value
 * @return mixed
 */
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)

    if (function_exists('json_encode')) {
        return json_encode($value);
    } else {
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = '"' . str_replace($escapers, $replacements, $value) . '"';
        return $result;
    }
}


?>