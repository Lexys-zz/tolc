<?php
session_start();
session_regenerate_id(true);

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

// get vars
$www_page_versions_id = 1;

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get current user
$a_user = get_user($conn, $_SESSION['username']);
$www_users_id = $a_user['user_id'];
$lk_roles_id = $a_user['lk_roles_id'];
$user_email = $a_user['user_email'];

// get current time (in UTC)
$dt = now();

// get page
$a_page = get_page($conn, $_SESSION['url']);
$www_pages_id = $a_page['page_id'];
$page_title = $a_page['page_title'];
$page_has_been_removed = $a_page['page_has_been_removed'];

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

// free memory from database objects
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();

print $page_html;

?>

