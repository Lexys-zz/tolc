<?php
session_start();
session_regenerate_id(true);

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
$page_title = $_POST['page_title'];
$www_templates_id = $_POST['www_templates_id'];
$parent_id = $_POST['parent_id'];

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get current time (in UTC)
$now = $conn->qstr(now());

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

if(preg_match(CONST_REGEX_SANITIZE_URL, $page_url)) {
	print gettext('Invalid URL') . '.' . ' ' . gettext('Valid URL may contain letters, digits, space and the characters') . ' '. '.-_/';
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
	$now .
	')';
if($conn->Execute($sql) === false) {
	$err = $conn->ErrorMsg();
	$conn->RollbackTrans();
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
}

// insert first version for new inserted page
$sql = 'INSERT INTO www_page_versions ' .
	'(www_pages_id,lk_content_status_id,date_inserted,author_id) ' .
	'VALUES (' .
	$www_pages_id . ',' .
	CONST_CONTENT_STATUS_DRAFT_KEY . ',' .
	$now . ',' .
	$www_users_id .
	')';
if($conn->Execute($sql) === false) {
	$err = $conn->ErrorMsg();
	$conn->RollbackTrans();
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $err, E_USER_ERROR);
}

$conn->CommitTrans();

$_SESSION['url'] = $page_url;
?>