<?php
// -----------------------------------------------------------------------------
// URI - USE OF DOMAIN
// -----------------------------------------------------------------------------
define('DOMAIN_USED', true);

// -----------------------------------------------------------------------------
// URI - PATH MAPPING
// -----------------------------------------------------------------------------
define('PROJECT_DIR', DOMAIN_USED ? $_SERVER['DOCUMENT_ROOT'] : '/path/to/tolc');
define('PROJECT_URL', DOMAIN_USED ? '' : '/url/to/tolc');
define('BASE_URL', PROJECT_URL . '/');

$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$http_prot = empty($_SERVER['HTTPS']) ? 'http' : 'https';
define('PROJECT_HOST', $http_prot . '://' . $host . $port);
define('PROJECT_FULL_URL', PROJECT_HOST . PROJECT_URL);

// -----------------------------------------------------------------------------
// DATABASE PER DOMAIN (or SERVER NAME or IP)
// -----------------------------------------------------------------------------
$domains_db['tolc.lo'] = 'dev_tolc';
$domains_db['www.tolc.lo'] = 'dev_tolc';
$domains_db['localhost'] = 'dev_tolc';

// -----------------------------------------------------------------------------
// DEFAULT TEMPLATE PER DOMAIN (or SERVER NAME or IP)
// -----------------------------------------------------------------------------
$domains_tmpl['tolc.lo'] = 1;
$domains_tmpl['www.tolc.lo'] = 1;
$domains_tmpl['localhost'] = 1;

// -----------------------------------------------------------------------------
// DATABASE CONNECTION STRING
// -----------------------------------------------------------------------------
$DBType = 'mysqlt';
$DBServer = 'localhost';
$DBUser = 'username'; 
$DBPass = rawurlencode('password'); 
$DBName = $domains_db[$host];

$dsn_options='?persist=0&fetchmode=2';
$dsn = "$DBType://$DBUser:$DBPass@$DBServer/$DBName$dsn_options";

// -----------------------------------------------------------------------------
// GLOBAL PREFERENCES
// -----------------------------------------------------------------------------
// valid origins
$valid_origins = array('tolc.lo',
    'www.tolc.lo',
    'localhost');

// error reporting
error_reporting(E_ALL ^ E_NOTICE);

// locale
define('PREF_DEFAULT_LOCALE_CODE', 'en_GB');
define('PREF_DEFAULT_LOCALE_ENCODING', '.UTF-8');
define('PREF_DEFAULT_LOCALE', PREF_DEFAULT_LOCALE_CODE . PREF_DEFAULT_LOCALE_ENCODING);

// special urls
define('PREF_LOGIN_URL', '/login');

// tidy
define('PREF_USE_TIDY', true);
define('PREF_LOGIN_URL', '/login');
define('PREF_TIDY_CONFIG', serialize(array('indent' => TRUE,
    'output-xhtml' => TRUE,
    'wrap' => 200))); /* http://tidy.sourceforge.net/docs/quickref.html */
define('PREF_TIDY_ENCODING', 'UTF8');

// regional settings
define('PREF_TIMEZONE', 'UTC'); // visitor default timezone

define('PREF_DATE_SEPARATOR', '/');
define('PREF_DATE_FORMAT_DATETIME_FULL', 'd' . PREF_DATE_SEPARATOR . 'm' . PREF_DATE_SEPARATOR . 'Y' . ' ' . 'H:i:s');
define('PREF_DATE_FORMAT_DATETIME', 'd' . PREF_DATE_SEPARATOR . 'm' . PREF_DATE_SEPARATOR . 'Y' . ' ' . 'H:i');
define('PREF_DATE_FORMAT_DATE', 'd' . PREF_DATE_SEPARATOR . 'm' . PREF_DATE_SEPARATOR . 'Y');
define('PREF_DATE_FORMAT_TIMESTAMP_FULL', 'YmdHis');
define('PREF_DATE_FORMAT_TIMESTAMP', 'YmdHi');

define('PREF_DECIMAL_MARK', ',');
define('PREF_THOUSANDS_SEPARATOR', '.');

// other
define('PREF_AUTOCOMPLETE_ROWS', 10);
?>