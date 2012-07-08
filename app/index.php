<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['isLoggedIn']))
    $_SESSION['isLoggedIn'] = false;
require_once 'common/settings.php';
if (!isset($_SESSION['www_languages_id']))
    $_SESSION['www_languages_id'] = PREF_DEFAULT_LANG_ID;
require_once 'common/constants.php';
require_once 'common/error_handler.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';
require_once 'common/utils.php';

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// get url
$url = DOMAIN_USED ? urldecode($_SERVER['REQUEST_URI']) : mb_substr(urldecode($_SERVER['REQUEST_URI']), mb_strlen(PROJECT_URL));
//print '$url = ' . $url . '<br>';
//print '$_SESSION[url] = ' . $_SESSION['url'] . '<br>';

$login = isset($_SESSION['login']) ? true : false;
if ($url == PREF_LOGIN_URL) {
    $_SESSION['login'] = true;
    $url_to_go = isset($_SESSION['url']) ? $_SESSION['url'] : '';
    header('Location: ' . PROJECT_FULL_URL . $url_to_go);
} else {
    unset($_SESSION['login']);
    $url_sql = $conn->qstr($url);
    $_SESSION['url'] = $url;
}

// define mode
$admin_mode = $_SESSION['isLoggedIn'];

$sql = 'SELECT id FROM www_pages WHERE url=' . $url_sql;
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if ($rs->RecordCount() == 0) {
    $new_page = true;
    // get default template
    $sql = 'SELECT template_path, template_file FROM www_templates WHERE id = ' . $domains_tmpl[$host];
} else {
    $new_page = false;
    // get template for this url
    $sql = 'SELECT t.template_path, t.template_file FROM www_pages p INNER JOIN www_templates t ON (p.www_templates_id = t.id) ' .
        'WHERE p.url = ' . $url_sql;
}

$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
$template_path = $rs->fields['template_path'];
$template_file = $rs->fields['template_file'];

define('TEMPLATE_URL', PROJECT_HOST . PROJECT_URL . $template_path);
include PROJECT_DIR . $template_path . $template_file;

// free memory
if ($rs)
    $rs->Close();
//database disconnect
if ($conn)
    $conn->Close();
?>












