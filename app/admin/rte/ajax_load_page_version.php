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

// get current time (in UTC)
$dt = now($_SESSION['user_timezone']);

// get vars
$www_page_versions_id = $_POST['www_page_versions_id'];

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// init
$a_res = array();
$a_content_status_keys = array(
	CONST_CONTENT_STATUS_DRAFT_KEY,
	CONST_CONTENT_STATUS_PENDING_REVIEW_KEY,
	CONST_CONTENT_STATUS_UNDER_REVIEW_KEY,
	CONST_CONTENT_STATUS_APPROVED_KEY,
	CONST_CONTENT_STATUS_REJECTED_KEY
);

$a_content_status_values = array(
	CONST_CONTENT_STATUS_DRAFT_VALUE,
	CONST_CONTENT_STATUS_PENDING_REVIEW_VALUE,
	CONST_CONTENT_STATUS_UNDER_REVIEW_VALUE,
	CONST_CONTENT_STATUS_APPROVED_VALUE,
	CONST_CONTENT_STATUS_REJECTED_VALUE
);

$a_content_status = array(
	CONST_CONTENT_STATUS_DRAFT_KEY => CONST_CONTENT_STATUS_DRAFT_VALUE,
	CONST_CONTENT_STATUS_PENDING_REVIEW_KEY => CONST_CONTENT_STATUS_PENDING_REVIEW_VALUE,
	CONST_CONTENT_STATUS_UNDER_REVIEW_KEY => CONST_CONTENT_STATUS_UNDER_REVIEW_VALUE,
	CONST_CONTENT_STATUS_APPROVED_KEY => CONST_CONTENT_STATUS_APPROVED_VALUE,
	CONST_CONTENT_STATUS_REJECTED_KEY => CONST_CONTENT_STATUS_REJECTED_VALUE
);

$a_content_status_css = array(
	CONST_CONTENT_STATUS_DRAFT_KEY => 'status_draft',
	CONST_CONTENT_STATUS_PENDING_REVIEW_KEY => 'status_pending_review',
	CONST_CONTENT_STATUS_UNDER_REVIEW_KEY => 'status_under_review',
	CONST_CONTENT_STATUS_APPROVED_KEY => 'status_approved',
	CONST_CONTENT_STATUS_REJECTED_KEY => 'status_rejected'
);


// get page
$a_page = get_page($conn, $_SESSION['url']);
$www_pages_id = $a_page['page_id'];
$page_title = $a_page['page_title'];
$page_has_been_removed = $a_page['page_has_been_removed'];

// get page version
if($www_page_versions_id == 0) {

}

// get page versions -----------------------------------------------------------
$a_page_versions = array();
$sql = 'SELECT pv.id,pv.date_inserted,a.fullname as author_fullname,pv.lk_content_status_id,pv.date_publish_start,pv.date_publish_end,e.fullname as editor_fullname ' .
	'FROM www_page_versions pv ' .
	'LEFT JOIN www_users a ON (pv.author_id = a.id) ' .
	'LEFT JOIN www_users e ON (pv.editor_id = e.id) ' .
	'WHERE pv.www_pages_id = ' . $www_pages_id . ' ' .
	'ORDER BY pv.date_publish_start DESC';

$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if($rs->RecordCount() == 0) {

} else {
	$a_pv = $rs->GetRows();

	foreach($a_pv as $pv) {
		$version_id = $pv['id'];
		$version = '(' . date_decode($pv['date_inserted'], $_SESSION['user_timezone'], $a_date_format[$_SESSION['user_dateformat']]['php_datetime']) . ') ' .
			gettext('Submitted from') . ': ' . $pv['author_fullname'] . '. ' .
			gettext('Published from') . ': ' . date_decode($pv['date_publish_start'], $_SESSION['user_timezone'], $a_date_format[$_SESSION['user_dateformat']]['php_datetime']) .
			($pv['date_publish_end'] ? ' ' . gettext('until') . ' ' . date_decode($pv['date_publish_end'], $_SESSION['user_timezone'], $a_date_format[$_SESSION['user_dateformat']]['php_datetime']) : '') .
			'. ' .
			gettext('Status') . ': ' . $a_content_status[$pv['lk_content_status_id']] . '. ' .
			($pv['editor_fullname'] ? gettext('Managed by') . ': ' . $pv['editor_fullname'] . '.' : '');
		$lk_content_status_id = $pv['lk_content_status_id'];
		$a_tmp = array(
			'version_id' => $version_id,
			'version' => $version,
			'content_status' => $lk_content_status_id
		);
		array_push($a_page_versions, $a_tmp);
	}
}

$a_res['page_versions'] = $a_page_versions;


// authors ---------------------------------------------------------------------
$sql = 'SELECT id, fullname FROM www_users ORDER BY fullname';
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$a_res['authors'] = $rs->GetRows();

// editors ---------------------------------------------------------------------
$sql = 'SELECT id, fullname FROM www_users WHERE lk_roles_id < ' . CONST_ROLE_COMMON_USER_KEY . ' ORDER BY fullname';
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$a_res['editors'] = $rs->GetRows();

// content status --------------------------------------------------------------
$a_content_status_keys = array(
	CONST_CONTENT_STATUS_DRAFT_KEY,
	CONST_CONTENT_STATUS_PENDING_REVIEW_KEY,
	CONST_CONTENT_STATUS_UNDER_REVIEW_KEY,
	CONST_CONTENT_STATUS_APPROVED_KEY,
	CONST_CONTENT_STATUS_REJECTED_KEY
);

$a_content_status_values = array(
	CONST_CONTENT_STATUS_DRAFT_VALUE,
	CONST_CONTENT_STATUS_PENDING_REVIEW_VALUE,
	CONST_CONTENT_STATUS_UNDER_REVIEW_VALUE,
	CONST_CONTENT_STATUS_APPROVED_VALUE,
	CONST_CONTENT_STATUS_REJECTED_VALUE
);

$a_res['content_status_keys'] = $a_content_status_keys;
$a_res['content_status_values'] = $a_content_status_values;
$a_res['content_status_css'] = $a_content_status_css;

// page version content --------------------------------------------------------


// get current user
$a_user = get_user($conn, $_SESSION['username']);
$www_users_id = $a_user['user_id'];
$lk_roles_id = $a_user['lk_roles_id'];
$user_email = $a_user['user_email'];


// get template
$a_template = get_page_template($conn, $www_pages_id, $dt);
$www_templates_id = $a_template['template_id'];
$template_path = $a_template['template_path'];
$template_file = $a_template['template_file'];
$css_url = $a_template['css_url'];
$template_base_url = $tolc_conf['project_url'] . $template_path;

// store template html to variable
ob_start();
include($tolc_conf['project_dir'] . $template_path . $template_file);
$template_html = ob_get_contents();
ob_end_clean();

// create a DOM object
$html = new simple_html_dom();

// load template html
$html->load($template_html);

// set template elements src attribute relevant to website root
$html = set_template_src_attribute($html, $template_base_url);

// set page content
$html = set_page_version_content($conn, $www_page_versions_id, $www_templates_id, $html);

// remove page head
$template_head = $html->getElementByTagName('head');
if($template_head) {
	$template_head->outertext = '';
}

// store DOM object to variable
$page_html = $html->save();

// clear DOM object
$html->clear();

$a_res['html'] = $page_html;


// -----------------------------------------------------------------------------
// free memory from database objects
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();

// -----------------------------------------------------------------------------
print json_encode($a_res);

?>

