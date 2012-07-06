<?php
session_start();
session_regenerate_id();
require_once 'common/settings.php';
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

if ($url == PREF_LOGIN_URL) {
    $login = true;
    $url_sql =  $conn->qstr('/');
    $url_to_go = isset($_SESSION['url']) ? $_SESSION['url'] : '';
    //print '$url_to_go = ' . PROJECT_FULL_URL . $url_to_go . '<br>';
    //exit;
    header('Location: ' . PROJECT_FULL_URL . $url_to_go);
    //exit;
} else {

    $ftest = '/srv/http/dev/tolc/log/test.log';
    if (!file_exists($ftest)) {
        touch($ftest);
        $cur = 1;
    } else {
        $cur = file_get_contents($ftest);
        $cur = $cur + 1;
    }
    file_put_contents($ftest, $cur);

    $login = false;
    $url_sql =  $conn->qstr($url);
    $_SESSION['url'] = $url;
    //print 'nologin $_SESSION[url] = ' . $_SESSION['url'] . '<br>';
}

// define mode
$admin_mode = isset($_SESSION['isLoggedIn']) ? true : false;
//$admin_mode = true;

//exit;

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
$rs->Close();
//database disconnect
$conn->Close();

?>












