<?php
session_start();
session_regenerate_id(true);

require_once 'conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_cms.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// TODO REMOVE DEBUG
$debug = false;

// retrieve url
$url = mb_substr(urldecode($_SERVER['REQUEST_URI']), mb_strlen($tolc_conf['project_url']));

// check for valid URL
$url = trim($url);
$url = preg_replace('/\s+/', ' ', $url); //replace multiple spaces with one
$url = mb_substr($url, 0, min($tolc_conf['pref_url_max_length'], CONST_URL_DB_MAXLENGTH)); // truncate to max length
$invalid_url = preg_match(CONST_REGEX_SANITIZE_URL, $url) ? true : false;

// prevent direct access of '/app/index.php'
if($url == '/app/index.php' || $url == '/app/') {
	header('Location: ' . CONST_PROJECT_FULL_URL);
	exit;
}

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get current user
if(isset($_SESSION['username'])) {
	$a_user = get_user($conn, $_SESSION['username']);
	$www_users_id = $a_user['user_id'];
	$lk_roles_id = $a_user['lk_roles_id'];
	$user_email = $a_user['user_email'];
}

// get current time (in UTC)
$dt = now();

// check for reserved url (CASE INSENSITIVE)
if(in_array(mb_strtolower($url), array_map('mb_strtolower', $tolc_conf['pref_reserved_urls']))) {
	$_SESSION['url_reserved'] = $url;
	$url_to_go = isset($_SESSION['url']) ? $_SESSION['url'] : '';
	header('Location: ' . CONST_PROJECT_FULL_URL . $url_to_go);
	exit;
} else {
	$_SESSION['url'] = $url;
}

if(!$invalid_url) {
	// get page
	$a_page = get_page($conn, $url);
	$www_pages_id = $a_page['page_id'];
	$page_title = $a_page['page_title'];
	$page_has_been_removed = $a_page['page_has_been_removed'];

	// get page version (and redefine page_title if needed)
	if($www_pages_id == 0) {
		$www_page_versions_id = 0;
		$page_title = isset($_SESSION['username']) ? gettext('New page') : gettext('Page does not exist') . '...';
	} else {
		if($page_has_been_removed) {
			$www_page_versions_id = 0;
			$page_title = gettext('Page not found') . '...';
		} else {
			// get page current version
			$www_page_versions_id = get_page_version($conn, $www_pages_id, $dt, CONST_CONTENT_STATUS_APPROVED_KEY);
			if($www_page_versions_id == 0) {
				$page_title = gettext('Page not found') . '...';
			}
		}
	}
} else {
	$www_pages_id = 0;
	$www_page_versions_id = 0;
	$page_title = gettext('Invalid URL');
}

// TODO REMOVE DEBUG
if($debug) {
	echo 'www_users_id=' . $www_users_id . ' | ';
	echo 'lk_roles_id=' . $lk_roles_id . ' | ';
	echo 'url=' . $url . ' | ';
	echo 'www_pages_id=' . $www_pages_id . ' | ';
	echo 'www_page_versions_id=' . $www_page_versions_id . ' ';
	echo 'page_has_been_removed=' . ($page_has_been_removed ? 'yes' : 'no') . '<br>';
}

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

// parse template head
$a_tpl_head = parse_template_head($html, $template_base_url);
$template_favicon_html = $a_tpl_head['template_favicon_html'];
$template_link_html = $a_tpl_head['template_link_html'];
$template_scripts_html = $a_tpl_head['template_scripts_html'];
$template_meta_html = $a_tpl_head['template_meta_html'];

// get template active elements ids
$a_active_elements = get_template_active_elements($conn, $www_templates_id);
$active_elements = (isset($_SESSION['username']) && $www_pages_id > 0) ? implode(', ', $a_active_elements) : '';

// set page content
if($www_page_versions_id > 0) {
	$html = set_page_version_content($conn, $www_page_versions_id, $www_templates_id, $html);
}

// compose page title html
$page_title_html = '<title>' . $page_title . '</title>';

/*
 * parse tolc sections
 */
// allow inclusion of tolc_head_*.php tolc_panel.php tolc_functions.php
$tolc_include = true;
/**
 * set default favicon in case template has no favicon (just for Chrome)
 * http://code.google.com/p/chromium/issues/detail?id=39402
 * Chrome requests favicons on every request on pages that don't have a favicon
 * (SCRIPT MAY RUNS TWICE if .ico are not excluded from .htaccess, which is the default)
 */
// store tolc head favicon html to variable
if(mb_strlen($template_favicon_html == 0)) {
	ob_start();
	include($tolc_conf['project_dir'] . '/app/tolc_head_favicon.php');
	$tolc_head_favicon_html = ob_get_contents();
	ob_end_clean();
	$favicon_html = $tolc_head_favicon_html;
} else {
	$favicon_html = $template_favicon_html;
}

// store tolc head css html to variable
ob_start();
include($tolc_conf['project_dir'] . '/app/tolc_head_css.php');
$tolc_head_css_html = ob_get_contents();
ob_end_clean();

// store tolc head js html to variable
ob_start();
include($tolc_conf['project_dir'] . '/app/tolc_head_js.php');
$tolc_head_js_html = ob_get_contents();
ob_end_clean();

// store tolc panel html to variable
ob_start();
include($tolc_conf['project_dir'] . '/app/tolc_panel.php');
$tolc_panel_html = ob_get_contents();
ob_end_clean();

// store tolc functions html to variable
ob_start();
include($tolc_conf['project_dir'] . '/app/tolc_functions.php');
$tolc_functions_html = ob_get_contents();
ob_end_clean();

// TODO REMOVE DEBUG
if($debug) {
	$ftest = '/srv/http/dev/tolc/log/test.log';
	file_put_contents($ftest, '--->functions' . PHP_EOL . $tolc_functions_html . PHP_EOL . PHP_EOL, FILE_APPEND);
}

// create page head
$template_head = $html->getElementByTagName('head');
if($template_head) {
	$head = $page_title_html . PHP_EOL .
		$favicon_html . PHP_EOL .
		$template_meta_html . PHP_EOL .
		$tolc_head_css_html . PHP_EOL .
		$template_link_html . PHP_EOL .
		$tolc_head_js_html . PHP_EOL .
		$template_scripts_html;
	$template_head->innertext = $head;
}

// create page body
$template_body = $html->getElementByTagName('body');
if($template_body) {
	$template_body_html = $template_body->innertext;
	$body = $tolc_panel_html . PHP_EOL .
		$template_body_html . PHP_EOL .
		$tolc_functions_html;
	$template_body->innertext = $body;
}

// beautify and print page html
if($tolc_conf['pref_use_tidy'] && function_exists('tidy_parse_string')) {
	$tidy = tidy_parse_string($html, $tolc_conf['pref_tidy_config'], $tolc_conf['pref_tidy_encoding']);
	$tidy->cleanRepair();
	echo $tidy;
} else {
	echo $html;
}

// clear DOM object
$html->clear();

// free memory from database objects
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();
?>