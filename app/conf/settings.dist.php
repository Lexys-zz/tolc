<?php
/**
 * URI - USE OF DOMAIN
 */
$tolc_conf['domain_used'] = true;

/**
 * URI - PATH MAPPING
 */
$tolc_conf['project_dir'] = $tolc_conf['domain_used'] ? $_SERVER['DOCUMENT_ROOT'] : '/path/to/tolc';
$tolc_conf['project_url'] = $tolc_conf['domain_used'] ? '' : '/url/to/tolc';
$tolc_conf['base_url'] = $tolc_conf['project_url'] . '/';

$tolc_conf['host'] = $_SERVER['SERVER_NAME'];
$tolc_conf['port'] = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$tolc_conf['http_prot'] = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$tolc_conf['project_host'] = $tolc_conf['http_prot'] . '://' . $tolc_conf['host'] . $tolc_conf['port'];
$tolc_conf['project_full_url'] = $tolc_conf['project_host'] . $tolc_conf['project_url'] ;

/**
 * DATABASE PER DOMAIN (or SERVER NAME or IP)
 */
$tolc_conf['domains_db'] = array('tolc.lo' => 'dev_tolc','www.tolc.lo' => 'dev_tolc','localhost' => 'dev_tolc','athena' => 'dev_tolc',);

/**
 * DEFAULT TEMPLATE PER DOMAIN (or SERVER NAME or IP)
 */
$tolc_conf['domains_tmpl'] = array('tolc.lo' => 1,'www.tolc.lo' => 1,'localhost' => 1,'athena' => 1);

/**
 * DATABASE CONNECTION STRING
 */
$tolc_conf['dbtype'] = 'mysqlt';
$tolc_conf['dbserver'] = 'SERVER-NAME-OR-IP-HERE';
$tolc_conf['dbuser'] = 'USER-HERE';
$tolc_conf['dbpass'] = rawurlencode('PASSWORD_HERE');
$tolc_conf['dbname'] = $tolc_conf['domains_db'][$tolc_conf['host']];

$tolc_conf['dsn_options'] = '?persist=0&fetchmode=2';
$tolc_conf['dsn'] = $tolc_conf['dbtype'] . '://' . $tolc_conf['dbuser'] . ':' . $tolc_conf['dbpass'] . '@' . $tolc_conf['dbserver'] .'/' .$tolc_conf['dbname'] . $tolc_conf['dsn_options'];


/**
 * GLOBAL PREFERENCES
 */
/* valid origins */
$tolc_conf['valid_origins'] = array('tolc.lo','www.tolc.lo','localhost');

/* error reporting */
$tolc_conf['error_reporting'] = 'E_ALL';

/* locale */
$tolc_conf['pref_default_locale_code'] = 'en_GB';
$tolc_conf['pref_default_locale_encoding'] = '.UTF-8';
$tolc_conf['pref_default_locale'] = $tolc_conf['pref_default_locale_code'] . $tolc_conf['pref_default_locale_encoding'];


/* reserved urls */
$tolc_conf['pref_reserved_url_login'] = '/login';
$tolc_conf['pref_reserved_url_timezone'] = '/timezone';

/* tidy http://tidy.sourceforge.net/docs/quickref.html */
$tolc_conf['pref_use_tidy'] = true;
$tolc_conf['pref_tidy_config'] =  array('indent' => TRUE,'output-xhtml' => TRUE,'wrap' => 200);
$tolc_conf['pref_tidy_encoding'] = 'UTF8';

/* regional settings */
$tolc_conf['pref_timezone'] = 'UTC'; // visitor default timezone

$tolc_conf['pref_date_separator'] = '/';
$tolc_conf['pref_date_format_datetime_full'] = 'd' . $tolc_conf['pref_date_separator'] . 'm' . $tolc_conf['pref_date_separator'] . 'Y' . ' ' . 'H:i:s';
$tolc_conf['pref_date_format_datetime'] = 'd' . $tolc_conf['pref_date_separator'] . 'm' . $tolc_conf['pref_date_separator'] . 'Y' . ' ' . 'H:i';
$tolc_conf['pref_date_format_date'] = 'd' . $tolc_conf['pref_date_separator'] . 'm' . $tolc_conf['pref_date_separator'] . 'Y';
$tolc_conf['pref_date_format_timestamp_full'] = 'YmdHis';
$tolc_conf['pref_date_format_timestamp'] = 'YmdHi';

$tolc_conf['pref_decimal_mark'] = ',';
$tolc_conf['pref_thousands_separator'] = '.';

/* other */
$tolc_conf['pref_autocomplete_rows'] = 10;
?>