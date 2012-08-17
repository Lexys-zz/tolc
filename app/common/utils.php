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
function now($format_string = CONST_DATE_FORMAT_TIMESTAMP_FULL, $str_timezone = CONST_LOCAL_TIMEZONE) {
	return date_string_format('', $format_string, $str_timezone);
}

/**
 * Converts a 14-digit timestamp to date string
 *
 * @param $ts
 * @param string $format
 * @param string $str_timezone
 * @return string
 */
function date_decode1($ts, $format = CONST_DATE_FORMAT_DATETIME, $str_timezone = CONST_LOCAL_TIMEZONE) {
	date_default_timezone_set('UTC');
	$tz1 = new DateTimeZone('UTC');
	$date = new DateTime($ts, $tz1);
	$tz = new DateTimeZone($str_timezone);
	$date->setTimeZone($tz);
	return $date->format($format);
}


function date_decode($ts, $format = CONST_DATE_FORMAT_DATETIME, $str_user_timezone = CONST_LOCAL_TIMEZONE) {
	$userTimezone = new DateTimeZone($str_user_timezone);
	$localTimezone = new DateTimeZone('UTC');
	$localDateTime = new DateTime($ts, $localTimezone);
	$offset = $userTimezone->getOffset($localDateTime);
	//return $offset;
	return date($format, $localDateTime->format('U') + $offset);
}





/**
 * * Multi-byte CASE INSENSITIVE str_replace
 *
 * @param $co
 * @param $naCo
 * @param $wCzym
 * @return string
 * @source http://www.php.net/manual/en/function.mb-ereg-replace.php#55659
 */
function mb_str_ireplace($co, $naCo, $wCzym) {
	$wCzymM = mb_strtolower($wCzym);
	$coM = mb_strtolower($co);
	$offset = 0;

	while(!is_bool($poz = mb_strpos($wCzymM, $coM, $offset))) {
		$offset = $poz + mb_strlen($naCo);
		$wCzym = mb_substr($wCzym, 0, $poz) . $naCo . mb_substr($wCzym, $poz + mb_strlen($co));
		$wCzymM = mb_strtolower($wCzym);
	}

	return $wCzym;
}

/**
 * Timezones list with GMT offset
 *
 * @return array
 * @source http://stackoverflow.com/a/9328760
 */
function tz_list() {
	$zones_array = array();
	$timestamp = time();
	foreach(timezone_identifiers_list() as $key => $zone) {
		date_default_timezone_set($zone);
		$zones_array[$key]['zone'] = $zone;
		$zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
	}
	return $zones_array;
}

/**
 * Create dateformat array
 *
 * @param $a_df
 * @param $tz
 * @return array
 */
function df_list($a_df, $tz = CONST_LOCAL_TIMEZONE) {
	$df_array = array();
	$tz = new DateTimeZone($tz);
	$date = new DateTime('');
	$date->setTimeZone($tz);
	foreach($a_df as $df) {
		$dt = $date->format($df);
		$df_array[$df] = $dt;
	}
	return $df_array;
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param int|string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param bool|\boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array()) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if($img) {
		$url = '<img src="' . $url . '"';
		foreach($atts as $key => $val)
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

/**
 * Get Gravatar profile url
 *
 * @param $email
 * @param bool $decode_url
 * @return string
 * @source https://en.gravatar.com/site/implement/profiles/php/
 */
function get_gravatar_profile($email, $decode_url = false) {
	$url_encoded = 'http://www.gravatar.com/' . md5(strtolower(trim($email)));
	if(!$decode_url) {
		return $url_encoded;
	} else {
		$url = $url_encoded . '.php';
		$str = file_get_contents($url);
		if($str === false) {
			return $url_encoded;
		} else {
			$profile = unserialize($str);
			if(is_array($profile) && isset($profile['entry'])) {
				return $profile['entry'][0]['profileUrl'];
			} else {
				return $url_encoded;
			}
		}
	}

}
?>