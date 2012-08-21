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
$flag = $_POST['flag'];

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get page
$a_page = get_page($conn, $_SESSION['url']);
$www_pages_id = $a_page['page_id'];

// proceed to update
$sql = 'UPDATE www_pages SET is_removed = ' . $flag . ' WHERE id=' . $www_pages_id;
if($conn->Execute($sql) === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}

//database disconnect
if($conn)
	$conn->Close();

?>

