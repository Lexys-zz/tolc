<?php
session_start();
session_regenerate_id(true);

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
    print 'Access denied - not an AJAX request...';
    exit;
}

require_once '../common/settings.php';
require_once PROJECT_DIR . '/app/common/error_handler.php';
require_once PROJECT_DIR . '/app/common/init.php';
require_once PROJECT_DIR . '/app/common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once PROJECT_DIR . '/app/common/db_utils.php';

// get params
$username = $_POST['username'];
$password = md5($_POST['password']);
$language = $_POST['language'];

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// check valid user
$sql = 'SELECT * FROM www_users ' .
    'WHERE username=' . $conn->qstr($username) .
    ' AND password=' . $conn->qstr($password) .
    ' AND lk_user_status_id=' . CONST_USER_STATUS_ACTIVE_KEY;
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if ($rs->RecordCount() == 1) {
    // use case sensitive values
    if($rs->fields['username'] == $username && $rs->fields['password'] == $password) {
        $_SESSION['username'] = $username;
        $_SESSION['locale'] = $language . PREF_DEFAULT_LOCALE_ENCODING;
        $_SESSION['timezone'] = $rs->fields['timezone'];
    } else {
        print gettext('Login failed') . '...';
    }
} else {
    print gettext('Login failed') . '...';
}
?>