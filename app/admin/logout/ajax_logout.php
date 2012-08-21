<?php
session_start();
session_regenerate_id();

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if (!$isAjax) {
	print 'Access denied - not an AJAX request...' . ' (' . __FILE__ . ')';
    exit;
}

require_once '../../conf/settings.php';
require_once $tolc_conf['project_dir'] . '/app/common/init.php';

// check for logged in user
if (!isset($_SESSION['username'])) {
    print 	print 'Access denied' . ' (' . __FILE__ . ')';
    exit;
}

unset($_SESSION['username']);
unset($_SESSION['must_change_passwd']);
?>