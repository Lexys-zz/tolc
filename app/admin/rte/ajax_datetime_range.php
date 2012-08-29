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
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_cms.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}

// get vars
$dt = $_POST['dt'];

// init
$user_tz = $_SESSION['user_timezone'];
$user_df_php_datetime = $a_date_format[$_SESSION['user_dateformat']]['php_datetime'];
$a_res = array();

// convert to YYYYMMDDHHMMSS
date_default_timezone_set($user_tz);
$date = DateTime::createFromFormat($user_df_php_datetime, $dt);
$res = $date->format('YmdHis');
date_default_timezone_set(CONST_SERVER_TIMEZONE);

$minYear = substr($res, 0, 4);
$minMonth = substr($res, 4, 2);
$minDay = substr($res, 6, 2);
$minHour = substr($res, 8, 2);
$minMin = substr($res, 10, 2);
$minSec = substr($res, 12, 2);

$a_res = array(
	'minYear' => $minYear,
	'minMonth' => $minMonth,
	'minDay' => $minDay,
	'minHour' => $minHour,
	'minMin' => $minMin,
	'minSec' => $minSec
);

print json_encode($a_res);

?>

