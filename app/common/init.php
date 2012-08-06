<?php
if(strlen(session_id()) < 1) {
	session_start();
	session_regenerate_id(true);
}

/**
 * check valid origin
 */
if(!in_array($_SERVER['SERVER_NAME'], $tolc_conf['pref_valid_origins'])) {
	print 'Access denied - Invalid origin';
	exit;
}

/**
 * error handling
 */
error_reporting($tolc_conf['pref_error_reporting']);
set_error_handler('error_handler');

/**
 * constants based on settings
 */
$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$http_prot = empty($_SERVER['HTTPS']) ? 'http' : 'https';
define('CONST_PROJECT_HOST', $http_prot . '://' . $host . $port);
define('CONST_PROJECT_FULL_URL', CONST_PROJECT_HOST . $tolc_conf['project_url']);

/**
 * help
 */
define('CONST_HELP_TAG', '<img src="' . $tolc_conf['project_url'] . '/app/images/help.png">');

/**
 * localization (gettext)
 */
/* initialize $_SESSION['locale'] */
if(!isset($_SESSION['locale'])) {
	$_SESSION['locale'] = $tolc_conf['pref_default_locale_code'] . $tolc_conf['pref_default_locale_encoding'];
}
if(function_exists('gettext')) {
	$locale = $_SESSION['locale'];
	putenv("LC_ALL=$locale");
	setlocale(LC_ALL, $locale);
	bindtextdomain("tolc", $tolc_conf['project_dir'] . "/app/i18n");
	textdomain("tolc");
} else {
	require_once $tolc_conf['project_dir'] . '/app/common/gettext_missing.php';
}

/**
 * DATES HANDLING
 * all dates stored as strings, formatted as 14-digit timestamps in UTC
 * dates appeat to visitor using $_SESSION['timezone']
 */
/* set server default timezone (it is possible set to php.ini) */
define('CONST_DEFAULT_TIMEZONE', 'UTC');
date_default_timezone_set(CONST_DEFAULT_TIMEZONE);

define('CONST_DATE_FORMAT_TIMESTAMP_FULL', 'YmdHis');
define('CONST_DATE_FORMAT_TIMESTAMP', 'YmdHi');

define('CONST_DATE_FORMAT_DATETIME_FULL', $tolc_conf['pref_date_format'] . ' ' . 'H:i:s');
define('CONST_DATE_FORMAT_DATETIME', $tolc_conf['pref_date_format'] . ' ' . 'H:i');

$a_date_format = array(
	'm/d/Y',
	'm/d/y',
	'd/m/Y',
	'd/m/y',
	'm-d-Y',
	'm-d-y',
	'd-m-Y',
	'd-m-y',
	'D, M j, Y',
	'M j ' . "'" . 'y'
);

/* initialize $_SESSION['dateformat'] (default visitor dateformat) */
if(!isset($_SESSION['dateformat'])) {
	$_SESSION['dateformat'] = $tolc_conf['pref_date_format'];
}

/* initialize $_SESSION['timezone'] (default visitor timezone) */
if(!isset($_SESSION['timezone'])) {
	$_SESSION['timezone'] = $tolc_conf['pref_timezone'];
}

/**
 * constants TINYMCE
 * UPLOADS_URL must be writable from web server, trailing slash required
 */
define('CONST_BASE_URL', $tolc_conf['project_url'] . '/'); // used by tinymce
define('UPLOADS_URL', $tolc_conf['project_url'] . '/data/'); // used from ezfilemanager


/**
 * lookups
 */
/* user status */
define('CONST_USER_STATUS_PENDING_KEY', 1);
define('CONST_USER_STATUS_ACTIVE_KEY', 2);
define('CONST_USER_STATUS_INACTIVE_KEY', 3);
define('CONST_USER_STATUS_PENDING_VALUE', gettext('pending registration'));
define('CONST_USER_STATUS_ACTIVE_VALUE', gettext('active user'));
define('CONST_USER_STATUS_INACTIVE_VALUE', gettext('inactive user'));

/* user roles */
define('CONST_ROLE_ADMIN_KEY', 1);
define('CONST_ROLE_EDITOR_IN_CHIEF_KEY', 2);
define('CONST_ROLE_EDITOR_KEY', 3);
define('CONST_ROLE_COMMON_USER_KEY', 4);
define('CONST_ROLE_ADMIN_VALUE', gettext('admin'));
define('CONST_ROLE_EDITOR_IN_CHIEF_VALUE', gettext('editor in chief'));
define('CONST_ROLE_EDITOR_VALUE', gettext('editor'));
define('CONST_ROLE_COMMON_USER_VALUE', gettext('common user'));

$a_role_keys = array(CONST_ROLE_ADMIN_KEY,
	CONST_ROLE_EDITOR_IN_CHIEF_KEY,
	CONST_ROLE_EDITOR_KEY,
	CONST_ROLE_COMMON_USER_KEY
);
$a_role_values = array(CONST_ROLE_ADMIN_VALUE,
	CONST_ROLE_EDITOR_IN_CHIEF_VALUE,
	CONST_ROLE_EDITOR_VALUE,
	CONST_ROLE_COMMON_USER_VALUE
);

/* content status */
define('CONST_PUBLISH_STATUS_PENDING_KEY', 1);
define('CONST_PUBLISH_STATUS_PUBLISHED_KEY', 2);
define('CONST_PUBLISH_STATUS_DISCARDED_KEY', 3);
define('CONST_PUBLISH_STATUS_REMOVED_KEY', 4);

define('CONST_PUBLISH_STATUS_PENDING_VALUE', gettext('pending publication'));
define('CONST_PUBLISH_STATUS_PUBLISHED_VALUE', gettext('published'));
define('CONST_PUBLISH_STATUS_DISCARDED_VALUE', gettext('discarded'));
define('CONST_PUBLISH_STATUS_REMOVED_VALUE', gettext('removed'));

$a_publish_status_keys = array(CONST_PUBLISH_STATUS_PENDING_KEY,
	CONST_PUBLISH_STATUS_PUBLISHED_KEY,
	CONST_PUBLISH_STATUS_DISCARDED_KEY,
	CONST_PUBLISH_STATUS_REMOVED_KEY
);
$a_publish_status_values = array(CONST_PUBLISH_STATUS_PENDING_VALUE,
	CONST_PUBLISH_STATUS_PUBLISHED_VALUE,
	CONST_PUBLISH_STATUS_DISCARDED_VALUE,
	CONST_PUBLISH_STATUS_REMOVED_VALUE
);


/**
 * paths (lib)
 */
define('LIB_URL', $tolc_conf['project_url'] . '/lib');
define('LIB_DIR', $tolc_conf['project_dir'] . '/lib');
define('LIB_EXT_DIR', '/ext');

define('JQUERY_URL', LIB_URL . LIB_EXT_DIR . '/jquery-1.7.2/jquery-1.7.2.min.js');
define('JQUERY_UI_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.22.custom/js/jquery-ui-1.8.22.custom.min.js');
define('JQUERY_UI_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.22.custom/css/' . $tolc_conf['pref_jqueryui_theme'] . '/jquery-ui-1.8.22.custom.css');
define('JQUERY_UI_i18n_DIR', LIB_URL . LIB_EXT_DIR . '/jquery-ui-localize');
define('JQUERY_UI_DATETIMEPICKER_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.js');
define('JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-extensions/jquery.ui.autocomplete.html.js');
define('JQUERY_UI_LAYOUT_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc30.4/jquery.layout.js');
define('JQUERY_UI_LAYOUT_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc30.4/layout-default.css');
define('JQUERY_UI_DATETIMEPICKER_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.css');
define('JSTREE_URL', LIB_URL . LIB_EXT_DIR . '/jstree.v.pre1.0_fix1/jquery.jstree.js');
define('QTIP2_URL', LIB_URL . LIB_EXT_DIR . '/qtip2-b76ec373fd16b17ff683bd2893a36b401342396829/jquery.qtip.min.js');
define('QTIP2_CSS_URL', LIB_URL . LIB_EXT_DIR . '/qtip2-b76ec373fd16b17ff683bd2893a36b401342396829/jquery.qtip.css');
define('PASSWORDSTRENGTH_URL', LIB_URL . LIB_EXT_DIR . '/passwordstrength/passwordstrength.js');
define('PASSWORDSTRENGTH_CSS_URL', LIB_URL . LIB_EXT_DIR . '/passwordstrength/passwordstrength.css');
define('JUI_ALERT_URL', LIB_URL . '/jui_alert_1.0/jquery.jui_alert.js');

define('JQUERY_TINYMCE_DIR', '/tinymce_3.5.4.1_jquery');
define('JQUERY_TINYMCE_PATH', LIB_URL . LIB_EXT_DIR . JQUERY_TINYMCE_DIR);
define('JQUERY_TINYMCE_URL', JQUERY_TINYMCE_PATH . '/jquery.tinymce.js');
define('TINYMCE_URL', JQUERY_TINYMCE_PATH . '/tiny_mce.js');
define('TINYMCE_POPUP_URL', JQUERY_TINYMCE_PATH . '/tiny_mce_popup.js');
define('EZFILEMANAGER_URL', JQUERY_TINYMCE_PATH . '/plugins/ezfilemanager/index.php');

define('ADODB_PATH', LIB_DIR . LIB_EXT_DIR . '/adodb_5.17');

define('SIMPLE_HTML_DOM_PATH', LIB_DIR . LIB_EXT_DIR . '/simplehtmldom_1_5');

/**
 * @param $err_no
 * @param $err_str
 * @param $err_file
 * @param $err_line
 * Error handler function. Replaces PHP's error handler.
 * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING are always handled by PHP.
 * E_WARNING, E_NOTICE, E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE are handled by this function.
 */
function error_handler($err_no, $err_str, $err_file, $err_line) {
	// if error_reporting is set to 0, exit. This is also the case when using @
	if(ini_get('error_reporting') == '0')
		return;
	// handle error
	switch($err_no) {
		case E_WARNING:
			$msg = '[ErrNo=' . $err_no . ' (WARNING), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
			log_error($msg, (!defined('INSTALLING'))); // e.g. warnings are hidden while installing
			if(!defined('INSTALLING'))
				exit;
			break;
		case E_USER_ERROR:
			$msg = '[ErrNo=' . $err_no . ' (USER_ERROR), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
			log_error($msg);
			exit;
			break;
		case E_USER_WARNING:
			$msg = $err_str;
			set_last_message(false, $msg);
			header('Location: ' . CONST_PROJECT_FULL_URL);
			exit;
			break;
		case E_NOTICE:
		case E_USER_NOTICE:
		case 2048: // E_STRICT in PHP5
			// ignore
			break;
		default:
			// unknown error. Log in file (only) and continue execution
			$msg = '[ErrNo=' . $err_no . ' (UNKNOWN_ERROR), File=' . $err_file . ', Line=' . $err_line . '] ' . $err_str;
			log_error($msg, false);
			break;
	}
}

/**
 * @param $msg
 * @param bool $show_onscreen
 * Log an error to custom file (error.log in project's directory)
 */
function log_error($msg, $show_onscreen = true) {
	global $tolc_conf;
	// put in screen
	if($show_onscreen)
		print $msg;

	// put in file
	@error_log(date('Y-m-d H:i:s') . ': ' . $msg . "\n", 3, $tolc_conf['project_dir'] . '/log/error.log');
}

?>