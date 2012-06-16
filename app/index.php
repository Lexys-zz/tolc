<?php
require_once 'common/settings.php';
require_once 'common/constants.php';
require_once 'common/error_handler.php';
require_once 'common/gettext.php';
require_once ADODB_PATH . '/adodb.inc.php';


$conn = ADONewConnection($dsn);


$admin_mode = isset($_SESSION['isLoggedIn']) ? true : false;
$url = DOMAIN_USED ? urldecode($_SERVER['REQUEST_URI']) : mb_substr(urldecode($_SERVER['REQUEST_URI']), mb_strlen(PROJECT_URL));
echo 'url=' . $url . '<br>';

define('TEMPLATE_URL', PROJECT_URL . '/app/templates/variant-trio/');
include PROJECT_DIR . '/app/templates/variant-trio/index.php';

?>
