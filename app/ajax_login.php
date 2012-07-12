<?php
session_start();
session_regenerate_id(true);
require_once 'common/settings.php';
require_once 'common/error_handler.php';
require_once 'common/init.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';

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
        $_SESSION['is_admin'] = $rs->fields['is_admin'] == 1 ? true : false;
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['locale'] = $language . PREF_DEFAULT_LOCALE_ENCODING;

        // get languages id
        $sql = 'SELECT id FROM www_languages WHERE locale=' . $conn->qstr($language);
        $rs = $conn->Execute($sql);
        if ($rs === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
        }
        $_SESSION['www_languages_id'] = $rs->fields['id'];
    } else {
        print gettext('Login failed') . '...';
    }
} else {
    print gettext('Login failed') . '...';
}
?>