<?php
session_start();
session_regenerate_id(true);
unset($_SESSION['username']);
unset($_SESSION['is_admin']);
$_SESSION['isLoggedIn'] = false;
?>