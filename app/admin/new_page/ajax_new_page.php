<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
    print 'Access denied - not an AJAX request...';
    exit;
}

// check for logged in user
if(!isset($_SESSION['username'])) {
	print gettext('Access denied') . '...';
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

// get current user id
$sql='SELECT id FROM www_users WHERE username=' . $conn->qstr($_SESSION['username']);
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	$www_users_id = $rs->fields['id'];
}

// check for unique URL
$sql = 'SELECT id from www_pages WHERE LOWER(url)=' . $conn->qstr(mb_strtolower($page_url));
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	if($rs->RecordCount() !=0) {
		print gettext('URL already exists' . '...');
		exit;
	}
}

// check for unique page title
$sql = 'SELECT id from www_pages WHERE LOWER(title)=' . $conn->qstr(mb_strtolower($page_title));
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	if($rs->RecordCount() !=0) {
		print gettext('Page title already exists' . '...');
		exit;
	}
}

// insert new page
$sql = 'INSERT INTO www_pages ' .
	'(url,title,www_templates_id,www_users_id,date_created,parent_id) ' .
	'VALUES (' .
	$conn->qstr($page_url) . ',' .
	$conn->qstr($page_title) . ',' .
	$www_templates_id . ',' .
	$www_users_id . ',' .
	$conn->qstr(now()) . ',' .
	$parent_id .
	')';
if($conn->Execute($sql) === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
} else {
	$_SESSION['url'] = $page_url;
}

?>