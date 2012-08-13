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
 * @param $conn
 * @param $page_id
 * @param $dt
 * @param $content_status
 * @return int
 */
function get_page_version($conn, $page_id, $dt, $content_status) {

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


?>