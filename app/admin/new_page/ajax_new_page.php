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

// check for logged in user
if(!isset($_SESSION['username'])) {
	print 'Access denied' . ' (' . __FILE__ . ')';
	exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';

// get params
$page_url = $_POST['page_url'];
$page_title = htmlspecialchars($_POST['page_title'], ENT_QUOTES, CONST_UTF8);
$www_templates_id = $_POST['www_templates_id'];
$date_start = $_POST['date_start'];
$parent_id = $_POST['parent_id'];

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get current user id
$sql = 'SELECT id FROM www_users WHERE username=' . $conn->qstr($_SESSION['username']);
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	$www_users_id = $rs->fields['id'];
}

// check URL max lenght
if(mb_strlen($page_url) > $tolc_conf['pref_url_max_length']) {
	print gettext('Max length of URL is') . ' ' . $tolc_conf['pref_url_max_length'] . '...';
	exit;
}

// check for valid URL
if(preg_match('/\040\040/', $page_url)) {
	print gettext('Only one space allowed between words') . '...';
	exit;
}

// sanitize URL
$url_length = min($tolc_conf['pref_url_max_length'], CONST_URL_DB_MAXLENGTH);
$remove_accents = $tolc_conf['pref_url_remove_accents'];
$convert_to_lower_case = $tolc_conf['pref_url_convert_to_lower_case'];
$replace_space_between_words_with_dash = $tolc_conf['pref_url_replace_space_between_words_with_dash'];
$page_url = sanitize_url($page_url, $url_length, $remove_accents, $convert_to_lower_case, $replace_space_between_words_with_dash);

// check for valid URL
$valid_url = valid_url($page_url, CONST_REGEX_SANITIZE_URL, CONST_REGEX_SANITIZE_URL_LEGACY);

if(!$valid_url) {
	print gettext('Invalid URL') . '.' . ' ' . gettext('Valid URL may contain letters, digits, space and the characters') . ' ' . '.-_/';
	exit;
}

// check for unique URL
$sql = 'SELECT id from www_pages WHERE LOWER(url)=' . $conn->qstr(mb_strtolower($page_url));
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	if($rs->RecordCount() != 0) {
		print gettext('URL already exists') . '...';
		exit;
	}
}

// check valid datetime
$date_start = trim($date_start);
$user_tz = $_SESSION['user_timezone'];
$user_df_php_datetime = $a_date_format[$_SESSION['user_dateformat']]['php_datetime'];
if(!isValidDateTimeString($date_start, $user_df_php_datetime, $user_tz)) {
	print gettext('Invalid date') . '...';
	exit;
}
$date_start_encoded = date_encode($date_start, $user_tz, $user_df_php_datetime);
$date_start_sql = $conn->qstr($date_start_encoded);

// proceed to insert
$conn->BeginTrans();

// insert new page
$sql = 'INSERT INTO www_pages ' .
	'(url,title,parent_id) ' .
	'VALUES (' .
	$conn->qstr($page_url) . ',' .
	$conn->qstr($page_title) . ',' .
	$parent_id .
	')';
if($conn->Execute($sql) === false) {
	$err = $conn->ErrorMsg();
	$conn->RollbackTrans();
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
} else {
	$www_pages_id = $conn->Insert_ID();
}

// insert new template for new inserted page
$sql = 'INSERT INTO www_page_templates ' .
	'(www_pages_id,www_templates_id,date_start) ' .
	'VALUES (' .
	$www_pages_id . ',' .
	$www_templates_id . ',' .
	$date_start_sql .
	')';
if($conn->Execute($sql) === false) {
	$err = $conn->ErrorMsg();
	$conn->RollbackTrans();
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
}

$conn->CommitTrans();

$_SESSION['url'] = $page_url;
?>