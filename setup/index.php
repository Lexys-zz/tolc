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

$db_utils_php = PROJECT_DIR . '/app/common/db_utils.php';
$db_utils_php_dist = PROJECT_DIR . '/app/common/db_utils.dist.php';

$tolc_panel_css = PROJECT_DIR . '/app/common/tolc.panel.css';
$tolc_panel_css_dist = PROJECT_DIR . '/app/common/tolc.panel.dist.css';

$tolc_js_php = PROJECT_DIR . '/app/common/tolc.js.php';
$tolc_js_php_dist = PROJECT_DIR . '/app/common/tolc.js.dist.php';

$tolc_hidden_php = PROJECT_DIR . '/app/common/tolc.hidden.php';
$tolc_hidden_php_dist = PROJECT_DIR . '/app/common/tolc.hidden.dist.php';

$tinymce_fm_config = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/filemanager/config.php';
$tinymce_fm_config_dist = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/filemanager/config.php_';

$tinymce_ezfm_config = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/ezfilemanager/includes/config.php';
$tinymce_ezfm_config_dist = LIB_DIR . LIB_EXT_DIR . JQUERY_TINYMCE_DIR . '/plugins/ezfilemanager/includes/config.inc.php';

$cfgs = array();
$cfgs[] = array($htaccess, $htaccess_dist);
$cfgs[] = array($favicon, $favicon_dist);
$cfgs[] = array($settings_php, $settings_php_dist);
$cfgs[] = array($error_handler_php, $error_handler_php_dist);
$cfgs[] = array($db_utils_php, $db_utils_php_dist);
$cfgs[] = array($tolc_panel_css, $tolc_panel_css_dist);
$cfgs[] = array($tolc_js_php, $tolc_js_php_dist);
$cfgs[] = array($tolc_hidden_php, $tolc_hidden_php_dist);
//$cfgs[] = array($tinymce_fm_config, $tinymce_fm_config_dist);
//$cfgs[] = array($tinymce_ezfm_config, $tinymce_ezfm_config_dist);

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