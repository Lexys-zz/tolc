<?php
require_once 'common/settings.php';
require_once 'common/constants.php';
require_once 'common/error_handler.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';
require_once 'common/utils.php';

$json = '[';

// get params
$url = $_POST['url'];

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// get page title
$sql = 'SELECT * FROM www_pages WHERE url=' . $conn->qstr($url);
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if ($rs->RecordCount() == 0) {
    $html_title = gettext('New page');
    $www_pages_id = 0;
    $www_templates_id = 0;
} else {
    $html_title = $rs->fields['title'];
    $www_pages_id = $rs->fields['id'];
    $www_templates_id = $rs->fields['www_templates_id'];
}

$json .= '{"group": "html_title", "elem_id": "0", "content_type": "0", "content": ' . escapeJsonString($html_title) . '},';


// get template active elements ids
$sql = 'SELECT id, element_id FROM www_template_active_elements WHERE www_templates_id=' . $www_templates_id . ' ORDER BY display_order';
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$a_elements = $rs->GetRows();

foreach ($a_elements as $element) {
    // get content
    $sql = 'SELECT html, www_modules_id FROM www_content ' .
        'WHERE www_pages_id=' . $www_pages_id .
        ' AND www_template_active_elements_id=' . $element['id'];
    $rs = $conn->Execute($sql);
    if ($rs === false) {
        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
    }
    if($rs->RecordCount() == 1) {
        $json .= '{"group": "active_elems", "elem_id": "' . $element['element_id'] . '", "content_type": "1", "content": ' . escapeJsonString($rs->fields['html']) . '},';
    }
}

$json = mb_substr($json, 0, mb_strlen($json) - 1);
$json .= ']';

print $json;

?>