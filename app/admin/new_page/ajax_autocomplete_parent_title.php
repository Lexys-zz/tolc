<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
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

// connect to database
$conn = get_db_conn($tolc_conf['dbdriver']);

// get params
$term = trim($_GET['term']);
$result = '';

$pos = mb_strpos($term, "%");
if($pos === false) {

	$parts = explode(' ', $term);
	$p = count($parts);

	$sql = 'SELECT id, title, url FROM www_pages WHERE ';

	for($i = 0; $i < $p; $i++) {
		$sql .= ' (LOWER(title) LIKE ' . $conn->qstr('%' . mb_strtolower($parts[$i]) . '%') .
			' OR LOWER(url) LIKE ' . $conn->qstr('%' . mb_strtolower($parts[$i]) . '%') . ')';
		if($i < $p - 1) {
			$sql .= ' AND';
		}
	}

	$sql .= ' ORDER BY title';

	$rs = $conn->Execute($sql);
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
	} else {
		$res = $rs->GetRows();
		$total_results = $rs->RecordCount();
	}

	if($total_results > 0) {
		$json = '[';
		foreach($res as $row) {

			$value = $row['title'] . ' (' . CONST_PROJECT_FULL_URL . $row['url'] . ')';
			$label = $value;
			for($i = 0; $i < $p; $i++) {
				// highlight search results
				$label = mb_str_ireplace($parts[$i], '<u><strong>' . $parts[$i] . '</strong></u>', $label);
			}

			$value = json_encode($value);
			$label = json_encode($label);

			$json .= '{"id":' . $row['id'] .
				', "value": ' . $value .
				', "label": ' . $label .
				'},';
		}
		$json = mb_substr($json, 0, mb_strlen($json) - 1);
		$json .= ']';
	}

	$result = $json;
}
print $result;
?>