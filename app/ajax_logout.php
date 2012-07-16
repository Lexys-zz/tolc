<?php
session_start();
session_regenerate_id(true);

// prevent direct access
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    print 'Access denied - not an AJAX request...';
    exit;
}

unset($_SESSION['username']);
?>