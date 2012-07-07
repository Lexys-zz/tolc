<?php
session_start();
session_regenerate_id(true);
unset($_SESSION['username']);
$_SESSION['isLoggedIn'] = false;
?>