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
$conn=get_db_conn($DBType,$DBUser,$DBPass,$DBServer,$DBName,$dsn_options);

// get page title
$sql='SELECT title FROM www_pages WHERE url=' . $conn->qstr($url);
$rs=$conn->Execute($sql);
if($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if ($rs->RecordCount() == 0) {
    $html_title = gettext('New page');
} else {
    $html_title = $rs->fields['title'];
}



$json .= '{"group": "html_title", "key": "0", "val": ' . escapeJsonString($html_title) . '}';
$json .= ']';

print $json;

?>