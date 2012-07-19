<?php
session_start();
session_regenerate_id(true);
require_once 'common/settings.php';
require_once 'common/error_handler.php';
require_once 'common/init.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';
require_once 'common/utils.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// allow inclusion of tolc_head_*.php tolc_panel.php tolc_functions.php
$tolc_include = true;

// set default visitor timezone
if(!isset($_SESSION['timezone'])) {
	$_SESSION['timezone'] = PREF_TIMEZONE;
}

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// retrieve url
$url = DOMAIN_USED ? urldecode($_SERVER['REQUEST_URI']) : mb_substr(urldecode($_SERVER['REQUEST_URI']), mb_strlen(PROJECT_URL));

// check for reserved url
if(in_array($url, $a_reserved_urls)) {
	$_SESSION['url_reserved'] = $url;
	$url_to_go = isset($_SESSION['url']) ? $_SESSION['url'] : '';
	header('Location: ' . PROJECT_FULL_URL . $url_to_go);
} else {
	$url_sql = $conn->qstr($url);
	$_SESSION['url'] = $url;
}

// get template id and page title
$sql = 'SELECT id, title, www_templates_id FROM www_pages WHERE url=' . $url_sql;
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if($rs->RecordCount() == 0) {
	// set page id
	$www_pages_id = 0;
	// set default template id
	$www_templates_id = $domains_tmpl[$host];
	// set page title
	$page_title = $admin_mode ? gettext('New page') : gettext('Page not found') . '...';
} else {
	// retrieve page id
	$www_pages_id = $rs->fields['id'];
	// retrieve template id for this url
	$www_templates_id = $rs->fields['www_templates_id'];
	// retrieve page title
	$page_title = $rs->fields['title'];
}

// get template path
$sql = 'SELECT template_path, template_file, css_url FROM www_templates WHERE id = ' . $www_templates_id;
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$template_path = $rs->fields['template_path'];
$template_file = $rs->fields['template_file'];
$css_url = $rs->fields['css_url'];
$template_base_url = PROJECT_URL . $template_path;

// store template html to variable
ob_start();
include(PROJECT_DIR . $template_path . $template_file);
$template_html = ob_get_contents();
ob_end_clean();

// create a DOM object
$html = new simple_html_dom();

// load template html
$html->load($template_html);

// convert template head link href relevant to website root
$favicon_html = '';
$template_link_html = '';
$template_links = $html->find('link');
foreach($template_links as $template_link) {
	$link_rel = $template_link->rel;
	$link_href = $template_link->href;
	$template_link->href = $template_base_url . $link_href;
	if($link_rel == 'shortcut icon') {
		$favicon_html = $template_link->outertext;
	} else {
		$template_link_html .= $template_link->outertext;
	}
}

// convert template head script src relevant to website root
$template_scripts_html = '';
$template_scripts = $html->find('script');
foreach($template_scripts as $template_script) {
	$script_src = $template_script->src;
	$template_script->src = $template_base_url . $script_src;
	$template_scripts_html .= $template_script->outertext;
}

// collect template meta tags
$template_meta_html = '';
$template_meta_tags = $html->find('meta');
foreach($template_meta_tags as $template_meta_tag) {
	$template_meta_html .= $template_meta_tag->outertext;
}

// convert template images src relevant to website root
$template_images = $html->find('img[src]');
foreach($template_images as $template_image) {
	$img_src = $template_image->src;
	$template_image->src = $template_base_url . $img_src;
}

// convert template imput src relevant to website root
$template_inputs = $html->find('input[src]');
foreach($template_inputs as $template_input) {
	$input_src = $template_input->src;
	$template_input->src = $template_base_url . $input_src;
}

// set page content
$a_active_elements = array();
if($www_pages_id > 0) {
	// get template active elements ids
	$sql = 'SELECT id, element_id FROM www_template_active_elements WHERE www_templates_id=' . $www_templates_id . ' ORDER BY display_order';
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$a_elements = $rs->GetRows();

	$now = $conn->qstr(now());
	foreach($a_elements as $element) {
		// push to active elements array
		array_push($a_active_elements, '#' . $element['element_id']);
		// get content
		$sql = 'SELECT html FROM www_content ' .
			'WHERE www_pages_id=' . $www_pages_id .
			' AND www_template_active_elements_id=' . $element['id'] .
			' AND lk_publish_status_id=' . CONST_PUBLISH_STATUS_PUBLISHED_KEY .
			' AND date_start<=' . $now .
			' AND (date_end is null OR date_end>=' . $now . ')';
		$rs = $conn->Execute($sql);
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
		}
		if($rs->RecordCount() == 1) {
			// set element content
			$selector = '[id=' . $element['element_id'] . ']';
			$res = $html->find($selector, 0);
			if($res) {
				$res->innertext = $rs->fields['html'];
			}
		}
	}
}

// set value to active elements hidden input
$active_elements = implode(', ', $a_active_elements);

// page title html
$page_title_html = '<title>' . $page_title . '</title>';

if(mb_strlen($favicon_html) == 0) {
	// store tolc head favicon html to variable
	ob_start();
	include(PROJECT_DIR . '/app/tolc_head_favicon.php');
	$tolc_head_favicon_html = ob_get_contents();
	ob_end_clean();
	$favicon_html = $tolc_head_favicon_html;
}

// store tolc head css html to variable
ob_start();
include(PROJECT_DIR . '/app/tolc_head_css.php');
$tolc_head_css_html = ob_get_contents();
ob_end_clean();

// store tolc head js html to variable
ob_start();
include(PROJECT_DIR . '/app/tolc_head_js.php');
$tolc_head_js_html = ob_get_contents();
ob_end_clean();

// store tolc panel html to variable
ob_start();
include(PROJECT_DIR . '/app/tolc_panel.php');
$tolc_panel_html = ob_get_contents();
ob_end_clean();

// store tolc functions html to variable
ob_start();
include(PROJECT_DIR . '/app/tolc_functions.php');
$tolc_functions_html = ob_get_contents();
ob_end_clean();

// page head
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

// page body
$template_body = $html->getElementByTagName('body');
if($template_body) {
	$template_body_html = $template_body->innertext;
	$body = $tolc_panel_html . PHP_EOL .
		$template_body_html . PHP_EOL .
		$tolc_functions_html;
	$template_body->innertext = $body;
}

// beautify and print page html
if(PREF_USE_TIDY) {
	$tidy = tidy_parse_string($html, unserialize(PREF_TIDY_CONFIG), PREF_TIDY_ENCODING);
	$tidy->cleanRepair();
	echo $tidy;
} else {
	echo $html;
}

// clear DOM object
$html->clear();

// free memory
if($rs)
	$rs->Close();
//database disconnect
if($conn)
	$conn->Close();
?>