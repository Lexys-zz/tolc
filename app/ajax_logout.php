<?php
session_start();
session_regenerate_id(true);

// prevent direct access
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    print 'Access denied - not an AJAX request...';
    exit;
}
require_once 'common/settings.php';
require_once 'common/error_handler.php';
require_once 'common/init.php';

// check for logged in user
if(!isset($_SESSION['username'])) {
    print gettext('Access denied') . '...';
    exit;
}

unset($_SESSION['username']);
?>