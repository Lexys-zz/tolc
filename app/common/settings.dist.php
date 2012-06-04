<?php
// -----------------------------------------------------------------------------
// URI - USE OF DOMAIN
// -----------------------------------------------------------------------------
define('DOMAIN_USED', true); // CONFIGURE

// -----------------------------------------------------------------------------
// URI - PATH MAPPING
// -----------------------------------------------------------------------------
define('PROJECT_DIR', DOMAIN_USED ? $_SERVER['DOCUMENT_ROOT'] : '/path/to/tolc'); // CONFIGURE
define('PROJECT_URL', DOMAIN_USED ? '' : '/url/to/tolc'); // CONFIGURE

$host = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$http_prot = empty($_SERVER['HTTPS']) ? 'http' : 'https';
define('PROJECT_HOST', $http_prot . '://' . $host . $port);

// -----------------------------------------------------------------------------
// SITES DATABASE PER SITE
// -----------------------------------------------------------------------------
if (DOMAIN_USED) {
    $domains_db['tolc.lo'] = 'dev_tolc'; // CONFIGURE
    $domains_db['www.tolc.lo'] = 'dev_tolc'; // CONFIGURE
}

// -----------------------------------------------------------------------------
// DATABASE CONNECTION STRING
// -----------------------------------------------------------------------------
$DBServer = 'localhost'; // CONFIGURE
$DBUser = 'username'; // CONFIGURE
$DBPass = 'password'; // CONFIGURE
$DBName = $sites[$host];

// -----------------------------------------------------------------------------
// ERRORS
// -----------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);  // CONFIGURE

// -----------------------------------------------------------------------------
// GLOBAL PREFERENCES
// -----------------------------------------------------------------------------
define('PREF_CHARSET', 'utf-8');
define('PREF_DATE_SEPARATOR', '/');
define('PREF_DECIMAL_SYMBOL', ',');
define('PREF_GROUPING_SYMBOL', '.');
define('PREF_AUTOCOMPLETE_ROWS', 10);

?>