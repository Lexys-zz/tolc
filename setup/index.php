<?php
echo 'setup...';
exit;
$htaccess = PROJECT_DIR . '.htaccess';
$htaccess_src = PROJECT_DIR . '.htaccess_dist';

$settings_php = PROJECT_DIR . '/app/common/settings.php';
$settings_php_src = PROJECT_DIR . '/app/common/settings.dist.php';

$error_handler_php = PROJECT_DIR . '/app/common/error_handler.php';
$error_handler_php_src = PROJECT_DIR . '/app/common/error_handler.dist.php';

$tolc_js_php = PROJECT_DIR . '/app/common/tolc.js.php';
$tolc_js_php_src = PROJECT_DIR . '/app/common/tolc.js.dist.php';

$tinymce_fm_config = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/filemanager/config.php';
$tinymce_fm_config_src = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/filemanager/config.php_';

$tinymce_ezfm_config = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/ezfilemanager/includes/config.php';
$tinymce_ezfm_config_src = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/ezfilemanager/includes/config.inc.php';

$cfgs = array();
$cfgs[] = array($htaccess, $htaccess_src);
$cfgs[] = array($settings_php, $settings_php_src);
$cfgs[] = array($error_handler_php, $error_handler_php_src);
$cfgs[] = array($tolc_js_php, $tolc_js_php_src);
//$cfgs[] = array($tinymce_fm_config, $tinymce_fm_config_src);
//$cfgs[] = array($tinymce_ezfm_config, $tinymce_ezfm_config_src);

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