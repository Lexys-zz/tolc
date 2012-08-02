<?php
session_start();
session_regenerate_id(true);
require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils_db.php';
require_once $tolc_conf['project_dir'] . '/app/common/utils.php';
require_once SIMPLE_HTML_DOM_PATH . '/simple_html_dom.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
	print gettext('Access denied') . '...';
	exit;
}


// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

$url_sql = $conn->qstr(mb_strtolower($_SESSION['url']));

// get template id and page title (CASE INSENSITIVE URL search)
$sql = 'SELECT id, title, www_templates_id FROM www_pages WHERE LOWER(url)=' . $url_sql;
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
// retrieve page id
$www_pages_id = $rs->fields['id'];
// retrieve template id for this url
$www_templates_id = $rs->fields['www_templates_id'];
// retrieve page title
$page_title = $rs->fields['title'];

// get template path
$sql = 'SELECT template_path, template_file, css_url FROM www_templates WHERE id = ' . $www_templates_id;
$rs = $conn->Execute($sql);
if($rs === false) {
	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$template_path = $rs->fields['template_path'];
$template_file = $rs->fields['template_file'];
$css_url = $rs->fields['css_url'];
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

// convert template <img> src relevant to website root
$template_images = $html->find('img[src]');
foreach($template_images as $template_image) {
	$img_src = $template_image->src;
	$template_image->src = $template_base_url . $img_src;
}

// convert template <input> src relevant to website root
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


?>

