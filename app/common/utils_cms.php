<?php

/**
 * Get current user
 *
 * @param $conn
 * @param $username
 * @return array
 */
function get_user($conn, $username) {

	$sql = 'SELECT id, email, lk_roles_id FROM www_users WHERE username=' . $conn->qstr($username);
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$user_id = $rs->fields['id'];
	$lk_roles_id = $rs->fields['lk_roles_id'];
	$user_email = $rs->fields['email'];

	return array(
		'user_id' => $user_id,
		'lk_roles_id' => $lk_roles_id,
		'user_email' => $user_email
	);

}

/**
 * Get page properties
 *
 * @param $conn
 * @param $url
 * @return array
 */
function get_page($conn, $url) {

	global $tolc_conf;

	// get page properties (CASE INSENSITIVE URL search)
	if(!$tolc_conf['pref_use_prepared_statements']) {
		$sql = 'SELECT id, title, is_removed FROM www_pages WHERE LOWER(url)=' . $conn->qstr(mb_strtolower($url));
		$rs = $conn->Execute($sql);
	} else {
		$sql = 'SELECT id, title, is_removed FROM www_pages WHERE LOWER(url)=?';
		$pst = $conn->Prepare($sql);
		$rs = $conn->Execute($pst, array(mb_strtolower($url)));
	}
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}

	if($rs->RecordCount() == 0) {
		$page_id = 0;
		$page_title = null;
		$page_has_been_removed = null;
	} else {
		$page_id = $rs->fields['id'];
		$page_title = $rs->fields['title'];
		$page_has_been_removed = $rs->fields['is_removed'] == 1 ? true : false;
	}

	return array(
		'page_id' => $page_id,
		'page_title' => $page_title,
		'page_has_been_removed' => $page_has_been_removed
	);

}


/**
 * Get page version id for given datetime and content status
 *
 * If $use_all_versions, just return the last version
 *
 * @param $conn
 * @param $page_id
 * @param $dt
 * @param $content_status
 * @param bool $use_all_versions
 * @return int
 */
function get_page_version($conn, $page_id, $dt, $content_status, $use_all_versions = false) {

	$page_version = 0;

	$dt_safe = $conn->qstr($dt);

	$sql = 'SELECT id FROM www_page_versions ' .
		'WHERE www_pages_id=' . $page_id .
		' AND lk_content_status_id=' . $content_status .
		' AND date_publish_start<=' . $dt_safe .
		' AND (date_publish_end IS NULL OR date_publish_end>' . $dt_safe . ')' .
		' ORDER BY date_publish_start DESC';
	$rs = $conn->SelectLimit($sql, 1, 0);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}

	$page_version = ($rs->RecordCount() == 0) ? 0 : $rs->fields['id'];

	if($page_version == 0 && $use_all_versions) {
		$sql = 'SELECT id FROM www_page_versions ' .
			'WHERE www_pages_id=' . $page_id .
			' ORDER BY date_publish_start DESC';
		$rs = $conn->SelectLimit($sql, 1, 0);
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
		}

		$page_version = ($rs->RecordCount() == 0) ? 0 : $rs->fields['id'];
	}

	return $page_version;
}


/**
 * Get template_id for a page in certain time
 *
 * @param $conn
 * @param $page_id
 * @param $dt
 * @return array
 */
function get_page_template($conn, $page_id, $dt) {

	global $tolc_conf;
	$dt_safe = $conn->qstr($dt);

	if($page_id == 0) {
		// set default template id
		$template_id = $tolc_conf['domains_tmpl'][$_SERVER['SERVER_NAME']];
	} else {
		// get template id
		$sql = 'SELECT www_templates_id FROM www_page_templates ' .
			'WHERE www_pages_id=' . $page_id .
			' AND date_start<=' . $dt_safe .
			' ORDER BY date_start DESC';
		$rs = $conn->SelectLimit($sql, 1, 0);
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
		} else {
			$template_id = $rs->fields['www_templates_id'];
		}
	}

	// get template properties
	$sql = 'SELECT template_path, template_file, css_url FROM www_templates WHERE id = ' . $template_id;
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$template_path = $rs->fields['template_path'];
	$template_file = $rs->fields['template_file'];
	$css_url = $rs->fields['css_url'];

	$a_res = array(
		'template_id' => $template_id,
		'template_path' => $template_path,
		'template_file' => $template_file,
		'css_url' => $css_url
	);

	return $a_res;
}

/**
 * @param $html
 * @param $template_base_url
 * @return mixed
 */
function set_template_src_attribute($html, $template_base_url) {

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

	return $html;
}

/**
 * Parse template head
 *
 * @param $html
 * @param $template_base_url
 * @return array
 */
function parse_template_head($html, $template_base_url) {

	global $tolc_conf;

	// convert template head <link> href relevant to website root and collect <link> tags
	$template_favicon_html = '';
	$template_link_html = '';
	$template_links = $html->find('link');
	foreach($template_links as $template_link) {
		$link_rel = $template_link->rel;
		$link_href = $template_link->href;
		$link_href_modified = $template_base_url . $link_href;
		$template_link_tag = $template_link->outertext;
		$template_link_tag = implode($link_href_modified, mb_split($link_href, $template_link_tag));
		if($link_rel == 'shortcut icon') {
			$template_favicon_html = $template_link_tag;
		} else {
			$template_link_html .= $template_link_tag;
		}
	}

	// convert template head <script> src relevant to website root and collect <script> tags
	$template_scripts_html = '';
	$template_scripts = $html->find('script');
	foreach($template_scripts as $template_script) {
		$script_src = $template_script->src;
		$script_src_modified = $template_base_url . $script_src;
		$template_script_tag = $template_script->outertext;
		$template_script_tag = implode($script_src_modified, mb_split($script_src, $template_script_tag));
		$template_scripts_html .= $template_script_tag;
	}

	// collect template <meta> tags
	$template_meta_html = '';
	$template_meta_tags = $html->find('meta');
	foreach($template_meta_tags as $template_meta_tag) {
		$template_meta_html .= $template_meta_tag->outertext;
	}

	return array(
		'template_favicon_html' => $template_favicon_html,
		'template_link_html' => $template_link_html,
		'template_scripts_html' => $template_scripts_html,
		'template_meta_html' => $template_meta_html
	);
}

/**
 * Get active elements for given template
 *
 * @param $conn
 * @param $template_id
 * @return array
 */
function get_template_active_elements($conn, $template_id) {

	$sql = 'SELECT id, element_id FROM www_template_active_elements WHERE www_templates_id=' . $template_id . ' ORDER BY display_order';
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$a_elements = $rs->GetRows();

	$a_active_elements = array();
	foreach($a_elements as $element) {
		array_push($a_active_elements, '#' . $element['element_id']);
	}

	return $a_active_elements;
}

/**
 * @param $conn
 * @param $page_version_id
 * @param $template_id
 * @param $html
 * @return mixed
 */
function set_page_version_content($conn, $page_version_id, $template_id, $html) {

	$sql = 'SELECT id, element_id FROM www_template_active_elements WHERE www_templates_id=' . $template_id . ' ORDER BY display_order';
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$a_elements = $rs->GetRows();

	foreach($a_elements as $element) {

		// get content
		$sql = 'SELECT html FROM www_content ' .
			'WHERE www_page_versions_id=' . $page_version_id .
			' AND www_template_active_elements_id=' . $element['id'];
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

	return $html;
}

/**
 * @param $conn
 * @param $template_id
 * @param $str_html
 * @return array
 */
function get_page_version_content_from_string($conn, $template_id, $str_html) {

	$config = HTMLPurifier_Config::createDefault();
	$config->set('HTML.TidyLevel', 'medium');
	$purifier = new HTMLPurifier($config);

	$sql = 'SELECT id, element_id FROM www_template_active_elements WHERE www_templates_id=' . $template_id . ' ORDER BY display_order';
	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	}
	$a_elements = $rs->GetRows();

	$a_res = array();

	// create a DOM object
	$html = new simple_html_dom();

	// load template html
	$html->load($str_html);

	foreach($a_elements as $element) {

		$element_html  = '';
		$element_id = $element['id'];

		// set element content
		$selector = '[id=' . $element['element_id'] . ']';
		$res = $html->find($selector, 0);
		if($res) {
			$element_html = $res->innertext;
			// apply htmlpurifier
			$element_html = $purifier->purify($element_html);
		}

		array_push($a_res, array('www_template_active_elements_id' => $element_id , 'html' => $element_html));

	}

	return $a_res;
}

?>