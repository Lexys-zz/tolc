<?php
session_start();
session_regenerate_id(true);

// prevent direct access
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    print 'Access denied';
    exit;
}

unset($_SESSION['username']);
unset($_SESSION['is_admin']);
?>