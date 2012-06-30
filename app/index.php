<?php
require_once 'common/settings.php';
require_once 'common/constants.php';
require_once 'common/error_handler.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';
require_once 'common/utils.php';

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// define mode
$admin_mode = isset($_SESSION['isLoggedIn']) ? true : false;

// get url
$url = DOMAIN_USED ? urldecode($_SERVER['REQUEST_URI']) : mb_substr(urldecode($_SERVER['REQUEST_URI']), mb_strlen(PROJECT_URL));

$sql='SELECT id FROM www_pages WHERE url=' . $conn->qstr($url);
$rs=$conn->Execute($sql);
if($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if($rs->RecordCount() == 0) {
    print 'Page not found...';
    exit;
}


// get template for this url
$sql = 'SELECT t.template_path FROM www_pages p INNER JOIN www_templates t ON (p.www_templates_id = t.id) ' .
       'WHERE p.url = ' . $conn->qstr($url);
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if($rs->RecordCount() == 1) {
    $template_path = $rs->fields['template_path'];
    define('TEMPLATE_URL', PROJECT_URL . $template_path . '/');
    include PROJECT_DIR . $template_path . '/index.php';
} else {
    print 'No template found...';
}

// free memory
$rs->Close();
//database disconnect
$conn->Close();

?>












