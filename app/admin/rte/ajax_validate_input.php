<?php
session_start();
session_regenerate_id();

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
	print 'Access denied - not an AJAX request...' . ' (' . __FILE__ . ')';
	exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}

// init
$user_tz = $_SESSION['user_timezone'];
$user_df_php_datetime = $a_date_format[$_SESSION['user_dateformat']]['php_datetime'];
$res = '';

// get vars
$date_publish_start = $_POST['date_publish_start'];
$date_publish_end = $_POST['date_publish_end'];

if(mb_strlen($date_publish_start) == 0) {
	$res=gettext('Please, give start date');
	print $res;
	exit;
}

if(!isValidDateTimeString($date_publish_start, $user_df_php_datetime, $user_tz)) {
	$res=gettext('Start date is not valid');
	print $res;
	exit;
}

if(mb_strlen($date_publish_end) > 0) {

	if(!isValidDateTimeString($date_publish_end, $user_df_php_datetime, $user_tz)) {
		$res=gettext('End date is not valid');
		print $res;
		exit;
	}

	// set timezone to user timezone
	date_default_timezone_set($user_tz);
    // create DateTime objects
	$dt_start = DateTime::createFromFormat($user_df_php_datetime, $date_publish_start);
	$dt_end = DateTime::createFromFormat($user_df_php_datetime, $date_publish_end);
	// return timezone to server default
	date_default_timezone_set(CONST_SERVER_TIMEZONE);

	// As of PHP 5.2.2, DateTime objects can be compared using comparison operators.
	// http://php.net/manual/en/datetime.diff.php
	if($dt_end <= $dt_start) {
		$res=gettext('End date must be greater than start date');
		print $res;
		exit;
	}
}

print $res;

?>

