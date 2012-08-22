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
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_cms.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print CONST_ACCESS_DENIED . ' (' . __FILE__ . ')';
	exit;
}

// init
$user_tz = $_SESSION['user_timezone'];
$user_df_php_datetime = $a_date_format[$_SESSION['user_dateformat']]['php_datetime'];
$res = array();

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get current time (in UTC)
$now = $conn->qstr(now($user_tz));

// get vars
$www_pages_id = $_POST['www_pages_id'];
$author_id = $_POST['author_id'];
$date_publish_start = $_POST['date_publish_start'];
$date_publish_end = $_POST['date_publish_end'];
$lk_content_status_id = $_POST['lk_content_status_id'];
$editor_id = $_POST['editor_id'];
$html = $_POST['html'];

$date_publish_start_encoded = date_encode($date_publish_start, $user_tz, $user_df_php_datetime);
$date_publish_start_sql = $conn->qstr($date_publish_start_encoded);
$date_publish_end_sql = $date_publish_end > 0 ? $conn->qstr(date_encode($date_publish_end, $user_tz, $user_df_php_datetime)) : 'null';
$editor_id_sql = $editor_id > 0 ? $editor_id : 'null';

// get template
$a_template = get_page_template($conn, $www_pages_id, $date_publish_start_encoded);
$template_id = $a_template['template_id'];

// get active elements content
$a_page_version_content = get_page_version_content_from_string($conn, $template_id, $html);

// proceed to insert
$conn->BeginTrans();

// insert page version
$sql = 'INSERT INTO www_page_versions ' .
	'(www_pages_id,lk_content_status_id,date_inserted,date_publish_start,date_publish_end,author_id,editor_id) ' .
	'VALUES (' .
	$www_pages_id . ',' .
	$lk_content_status_id . ',' .
	$now . ',' .
	$date_publish_start_sql . ',' .
	$date_publish_end_sql . ',' .
	$author_id . ',' .
	$editor_id_sql .
	')';
if($conn->Execute($sql) === false) {
	$err = $conn->ErrorMsg();
	$conn->RollbackTrans();
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
} else {
	$www_page_versions_id = $conn->Insert_ID();
}

// insert new page version content
foreach($a_page_version_content as $a_element_content) {

	$www_template_active_elements_id = $a_element_content['www_template_active_elements_id'];
	$html = $conn->qstr($a_element_content['html']);

	$sql = 'INSERT INTO www_content ' .
		'(www_page_versions_id,www_template_active_elements_id,html) ' .
		'VALUES (' .
		$www_page_versions_id . ',' .
		$www_template_active_elements_id . ',' .
		$html .
		')';
	if($conn->Execute($sql) === false) {
		$err = $conn->ErrorMsg();
		$conn->RollbackTrans();
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
	}
}

$conn->CommitTrans();

// -----------------------------------------------------------------------------
$res = array('www_page_versions_id' => $www_page_versions_id);

print json_encode($res);

?>

