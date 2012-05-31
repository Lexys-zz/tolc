<?php

define('PROJECT_FULL_URL', PROJECT_HOST . PROJECT_URL);


define('CSS_DEFAULT_URL', PROJECT_URL . '/css/default.css?version=1');

// LIB
define('LIB_URL', PROJECT_URL . '/lib');
define('LIB_DIR', PROJECT_DIR . '/lib');
define('LIB_EXT_DIR', '/ext');

define('JQUERY_URL', LIB_URL . LIB_EXT_DIR . '/jquery.v.1.7.1/jquery-1.7.1.min.js');

define('JQUERY_UI_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js');
define('JQUERY_UI_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css');
define('JQUERY_UI_i18n_DIR', LIB_URL . LIB_EXT_DIR . '/jquery-ui-localize');
define('JQUERY_UI_DATETIMEPICKER_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.js');
define('JQUERY_UI_EXT_AUTOCOMPLETE_HTML_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-extensions/jquery.ui.autocomplete.html.js');

define('JQUERY_UI_LAYOUT_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc29.14/jquery.layout.js');
define('JQUERY_UI_LAYOUT_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-layout.v.1.3.0-rc29.14/layout-default.css');

define('JSTREE_URL', LIB_URL . LIB_EXT_DIR . '/jstree.v.pre1.0_fix1/jquery.jstree.js');
define('JQUERY_CLIENT_URL', LIB_URL . LIB_EXT_DIR . '/jquery.client/jquery.client.js');
define('JQUERY_UI_DATETIMEPICKER_CSS_URL', LIB_URL . LIB_EXT_DIR . '/jquery-ui-timepicker-addon-0.9.8/jquery-ui-timepicker-addon.css');

define('JQUERY_GET_QUERY_PARAM_URL', LIB_URL . LIB_EXT_DIR . '/jquery.getQueryParam.1.0.0/jquery.getQueryParam.1.0.0.min.js');

define('JQUERY_SCROLLTO_URL', LIB_URL . LIB_EXT_DIR . '/jquery.scrollTo-1.4.2/jquery.scrollTo-min.js');

define('JQUERY_TINYMCE_DIR', '/tiny_mce_jquery_v.3.4.4');
define('JQUERY_TINYMCE_PATH', LIB_URL . LIB_EXT_DIR . JQUERY_TINYMCE_DIR);
define('JQUERY_TINYMCE_URL', JQUERY_TINYMCE_PATH . '/jquery.tinymce.js');
define('TINYMCE_URL', JQUERY_TINYMCE_PATH . '/tiny_mce.js');
define('TINYMCE_POPUP_URL', JQUERY_TINYMCE_PATH . '/tiny_mce_popup.js');
define('EZFILEMANAGER_URL', JQUERY_TINYMCE_PATH . '/plugins/ezfilemanager/index.php');

// adodb
define('ADODB_PATH', LIB_DIR . LIB_EXT_DIR . '/adodb_5.17');

?>