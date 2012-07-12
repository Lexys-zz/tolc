<?php

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

    if(function_exists('json_encode')) {
        return json_encode($value);
    } else {
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = '"' . str_replace($escapers, $replacements, $value) . '"';
        return $result;
    }
}


?>