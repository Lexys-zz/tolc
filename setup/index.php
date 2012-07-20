<?php
echo 'setup...';
exit;
$htaccess = PROJECT_DIR . '.htaccess';
$htaccess_dist = PROJECT_DIR . '.htaccess_dist';

$favicon = PROJECT_DIR . 'favicon.ico';
$favicon_dist = PROJECT_DIR . 'favicon_dist.ico';

$settings_php = PROJECT_DIR . '/app/common/settings.php';
$settings_php_dist = PROJECT_DIR . '/app/common/settings.dist.php';

$error_handler_php = PROJECT_DIR . '/app/common/error_handler.php';
$error_handler_php_dist = PROJECT_DIR . '/app/common/error_handler.dist.php';


$cfgs = array();
$cfgs[] = array($htaccess, $htaccess_dist);
$cfgs[] = array($favicon, $favicon_dist);
$cfgs[] = array($settings_php, $settings_php_dist);
$cfgs[] = array($error_handler_php, $error_handler_php_dist);

foreach ($cfgs as $cfg) {
    $dest = $cfg[0];
    $src = $cfg[1];
    if (!file_exists($dest)) {
        if (file_exists($src)) {
            copy($src, $dest);
        } else {
            touch($dest);
        }
    }
}

?>