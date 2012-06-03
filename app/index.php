<?php
require_once 'common/settings.php';
require_once 'common/constants.php';
require_once 'common/gettext.php';
require_once ADODB_PATH. '/adodb.inc.php';


echo _("Welcome");
echo '<br>';

echo 'HTTP_HOST=' . $_SERVER['HTTP_HOST'];
echo '<br>';

echo 'REQUEST_URI=' . $_SERVER['REQUEST_URI'];
echo '<br>';

?>