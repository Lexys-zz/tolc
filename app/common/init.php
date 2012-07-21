<?php
/**
 * check valid origin
 */
if(!in_array($_SERVER['SERVER_NAME'], $tolc_conf['pref_valid_origins'])) {
    print 'Access denied - Invalid origin';
    exit;
}

// constants based on settings
define('CONST_BASE_URL', $tolc_conf['project_url'] . '/'); // used by tinymce

$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$http_prot = empty($_SERVER['HTTPS']) ? 'http' : 'https';
define('CONST_PROJECT_HOST', $http_prot . '://' . $host . $port);
define('CONST_PROJECT_FULL_URL', CONST_PROJECT_HOST . $tolc_conf['project_url']);


/**
 * error handling
 */




// set php default timezone (it is possible set to php.ini) --------------------
define('CONST_DEFAULT_TIMEZONE', 'UTC');
date_default_timezone_set(CONST_DEFAULT_TIMEZONE);

define('CONST_PREF_DATE_FORMAT_TIMESTAMP_FULL', $tolc_conf['pref_date_format_timestamp_full']);
define('CONST_PREF_DATE_FORMAT_DATETIME', $tolc_conf['pref_date_format_datetime']);

// uploads dir (used from ezfilemanager)
define('UPLOADS_URL', $tolc_conf['project_url'] . '/data/'); // must be writable from web server, trailing slash required

// reserved urls
$a_reserved_urls = array($tolc_conf['pref_reserved_url_login'], $tolc_conf['pref_reserved_url_timezone']);

// CONSTANTS -------------------------------------------------------------------
// lookups
define('CONST_USER_STATUS_PENDING_KEY', 1);
define('CONST_USER_STATUS_ACTIVE_KEY', 2);
define('CONST_USER_STATUS_INACTIVE_KEY', 3);
define('CONST_USER_STATUS_PENDING_VALUE', gettext('pending registration'));
define('CONST_USER_STATUS_ACTIVE_VALUE', gettext('active user'));
define('CONST_USER_STATUS_INACTIVE_VALUE', gettext('inactive user'));

define('CONST_PUBLISH_STATUS_PENDING_KEY', 1);
define('CONST_PUBLISH_STATUS_PUBLISHED_KEY', 2);
define('CONST_PUBLISH_STATUS_DISCARDED_KEY', 3);
define('CONST_PUBLISH_STATUS_REMOVED_KEY', 4);
define('CONST_PUBLISH_STATUS_PENDING_VALUE', gettext('pending publication'));
define('CONST_PUBLISH_STATUS_PUBLISHED_VALUE', gettext('published'));
define('CONST_PUBLISH_STATUS_DISCARDED_VALUE', gettext('discarded'));
define('CONST_PUBLISH_STATUS_REMOVED_VALUE', gettext('removed'));

// paths (lib)
define('LIB_URL', $tolc_conf['project_url'] . '/lib');
define('LIB_DIR', $tolc_conf['project_dir'] . '/lib');
define('LIB_EXT_DIR', '/ext');

define('JQUERY_URL', LIB_URL . LIB_EXT_DIR . '/jquery-1.7.2/jquery-1.7.2.min.js');
define('JQUERY_UI_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.20.custom/js/jquery-ui-1.8.20.custom.min.js');
define('JQUERY_UI_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.20.custom/css/ui-lightness/jquery-ui-1.8.20.custom.css');
define('JQUERY_UI_i18n_DIR', LIB_URL . LIB_EXT_DIR . '/jquery-ui-localize');
define('JQUERY_UI_DATETIMEPICKER_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.js');
define('JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-extensions/jquery.ui.autocomplete.html.js');
define('JQUERY_UI_LAYOUT_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc30.4/jquery.layout.js');
define('JQUERY_UI_LAYOUT_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc30.4/layout-default.css');
define('JQUERY_UI_DATETIMEPICKER_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.css');
define('JSTREE_URL', LIB_URL . LIB_EXT_DIR . '/jstree.v.pre1.0_fix1/jquery.jstree.js');
define('QTIP2_URL', LIB_URL . LIB_EXT_DIR . '/qtip2-b76ec373fd16b17ff683bd2893a36b401342396829/jquery.qtip.min.js');
define('QTIP2_CSS_URL', LIB_URL . LIB_EXT_DIR . '/qtip2-b76ec373fd16b17ff683bd2893a36b401342396829/jquery.qtip.css');

define('JQUERY_TINYMCE_DIR', '/tinymce_3.5.4.1_jquery');
define('JQUERY_TINYMCE_PATH', LIB_URL . LIB_EXT_DIR . JQUERY_TINYMCE_DIR);
define('JQUERY_TINYMCE_URL', JQUERY_TINYMCE_PATH . '/jquery.tinymce.js');
define('TINYMCE_URL', JQUERY_TINYMCE_PATH . '/tiny_mce.js');
define('TINYMCE_POPUP_URL', JQUERY_TINYMCE_PATH . '/tiny_mce_popup.js');
define('EZFILEMANAGER_URL', JQUERY_TINYMCE_PATH . '/plugins/ezfilemanager/index.php');

define('ADODB_PATH', LIB_DIR . LIB_EXT_DIR . '/adodb_5.17');

define('SIMPLE_HTML_DOM_PATH', LIB_DIR . LIB_EXT_DIR . '/simplehtmldom_1_5');
?>