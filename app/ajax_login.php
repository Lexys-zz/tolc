<?php
session_start();
session_regenerate_id(true);
require_once 'common/settings.php';
require_once 'common/constants.php';
require_once 'common/error_handler.php';
//require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';
require_once 'common/db_utils.php';


// get params
$username = $_POST['username'];
$password = $_POST['password'];

// connect to database
$conn = get_db_conn($DBType, $DBUser, $DBPass, $DBServer, $DBName, $dsn_options);

// check valid user
$sql = 'SELECT * FROM www_users WHERE username=' . $conn->qstr($username) . ' AND password=' . $conn->qstr($password);
$rs = $conn->Execute($sql);
if ($rs === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->ErrorMsg(), E_USER_ERROR);
}
if ($rs->RecordCount() == 1) {
    // case sensitive
    if($rs->fields['username'] == $username && $rs->fields['password'] == $password) {
        $_SESSION['username'] = $username;
        $_SESSION['isLoggedIn'] = true;
    } else {
        print 'Login failed...';
    }
} else {
    print 'Login failed...';
}

?>