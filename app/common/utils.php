<?php


/**
 * http://stackoverflow.com/questions/1048487/phps-json-encode-does-not-escape-all-json-control-characters
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