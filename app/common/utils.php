<?php

/**
 * Converts current time for given timezone (considering DST) to 14-digit UTC timestamp (YYYYMMDDHHMMSS)
 *
 * DateTime requires PHP >= 5.2
 *
 * @param $str_user_timezone
 * @param string $str_server_timezone
 * @param string $str_server_dateformat
 * @return string
 */
function now($str_user_timezone,
			 $str_server_timezone = CONST_SERVER_TIMEZONE,
			 $str_server_dateformat = CONST_SERVER_DATEFORMAT) {

	// set timezone to user timezone
	date_default_timezone_set($str_user_timezone);

	$date = new DateTime('now');
	$date->setTimezone(new DateTimeZone($str_server_timezone));
	$str_server_now = $date->format($str_server_dateformat);

	// return timezone to server default
	date_default_timezone_set($str_server_timezone);

	return $str_server_now;
}


/**
 * Converts a 14-digit UTC timestamp to date string of given timezone (considering DST)
 *
 * DateTime requires PHP >= 5.2
 *
 * @param $str_server_datetime
 *
 * Normally is a 14-digit UTC timestamp (YYYYMMDDHHMMSS). It can also be 8-digit (date), 12-digit (datetime without seconds).
 * Missing digits filled with zero (000000 or 00).
 *
 * It can also be 'now', null or empty string. In this case returns the current time.
 *
 * Other values throw an error.
 *
 * @param string $str_user_timezone
 * @param $str_user_dateformat
 * @return string
 */
function date_decode($str_server_datetime,
					 $str_user_timezone,
					 $str_user_dateformat) {

	// create date object
	try {
		$date = new DateTime($str_server_datetime);
	} catch(Exception $e) {
		trigger_error('date_decode: Invalid datetime: ' . $e->getMessage(), E_USER_ERROR);
	}

	// convert to user timezone
	$userTimeZone = new DateTimeZone($str_user_timezone);
	$date->setTimeZone($userTimeZone);

	// convert to user dateformat
	$str_user_datetime = $date->format($str_user_dateformat);

	return $str_user_datetime;
}

/**
 * Converts a date string of given timezone (considering DST) and format to 14-digit UTC timestamp (YYYYMMDDHHMMSS)
 *
 * DateTime::createFromFormat requires PHP >= 5.3
 *
 * <li><b>Note about strtotime</b>: Dates in the m/d/y or d-m-y formats are disambiguated by looking at the separator between the various components:
 * if the separator is a slash (/), then the American m/d/y is assumed;
 * whereas if the separator is a dash (-) or a dot (.), then the European d-m-y format is assumed.
 *
 * To avoid potential ambiguity, it's best to use ISO 8601 (YYYY-MM-DD) dates or DateTime::createFromFormat() when possible.
 *
 * @param $str_user_datetime
 * @param $str_user_timezone
 * @param $str_user_dateformat
 * @param string $str_server_timezone
 * @param string $str_server_dateformat
 * @param string $str_safe_dateformat_strtotime
 * @return string
 *
 * @link http://www.php.net/manual/en/function.strtotime.php
 * @link http://stackoverflow.com/questions/4163641/php-using-strtotime-with-a-uk-date-format-dd-mm-yy
 * @link http://derickrethans.nl/british-date-format-parsing.html
 */
function date_encode($str_user_datetime,
					 $str_user_timezone,
					 $str_user_dateformat,
					 $str_server_timezone = CONST_SERVER_TIMEZONE,
					 $str_server_dateformat = CONST_SERVER_DATEFORMAT,
					 $str_safe_dateformat_strtotime = CONST_SAFE_DATEFORMAT_STRTOTIME) {

	// set timezone to user timezone
	date_default_timezone_set($str_user_timezone);

	// create date object using any given format
	if($str_user_datetime == 'now' || !$str_user_datetime) {
		$date = new DateTime('', new DateTimeZone($str_user_timezone));
	} else {
		$date = DateTime::createFromFormat($str_user_dateformat, $str_user_datetime, new DateTimeZone($str_user_timezone));
		if($date === false) {
			trigger_error('date_encode: Invalid date', E_USER_ERROR);
		}
	}

	// convert given datetime to safe format for strtotime
	$str_user_datetime = $date->format($str_safe_dateformat_strtotime);

	// convert to UTC
	$str_server_datetime = gmdate($str_server_dateformat, strtotime($str_user_datetime));

	// return timezone to server default
	date_default_timezone_set($str_server_timezone);

	return $str_server_datetime;
}

/**
 * Return the offset (in seconds) from UTC of a given timezone timestring (considering DST)
 *
 * @param $str_datetime
 * @param $str_timezone
 * @return int
 */
function get_time_offset($str_datetime, $str_timezone) {
	$timezone = new DateTimeZone($str_timezone);
	$offset = $timezone->getOffset(new DateTime($str_datetime));
	return $offset;
}

/**
 * * Multi-byte CASE INSENSITIVE str_replace
 *
 * @param $co
 * @param $naCo
 * @param $wCzym
 * @return string
 * @link http://www.php.net/manual/en/function.mb-ereg-replace.php#55659
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
 * @link http://stackoverflow.com/a/9328760
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
function df_list($a_df, $tz = CONST_SERVER_TIMEZONE) {
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
 * @link http://gravatar.com/site/implement/images/php/
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
 * @link https://en.gravatar.com/site/implement/profiles/php/
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