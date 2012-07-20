<?php
/**
 * URI - USE OF DOMAIN
 */
$conf['domain_used'] = true;

/**
 * URI - PATH MAPPING
 */
$conf['project_dir'] = $conf['domain_used'] ? $_SERVER['DOCUMENT_ROOT'] : '/srv/http/dev/tolc';
$conf['project_url'] = $conf['domain_used'] ? '' : '/dev/tolc';
$conf['base_url'] = $conf['project_url'] . '/';

$conf['host'] = $_SERVER['SERVER_NAME'];
$conf['port'] = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
$conf['http_prot'] = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$conf['project_host'] = $conf['http_prot'] . '://' . $conf['host'] . $conf['port'];
$conf['project_full_url'] = $conf['project_host'] . $conf['project_url'] ;

/**
 * DATABASE PER DOMAIN (or SERVER NAME or IP)
 */
$conf['domains_db'] = array('tolc.lo' => 'dev_tolc','www.tolc.lo' => 'dev_tolc','localhost' => 'dev_tolc','athena' => 'dev_tolc',);

/**
 * DEFAULT TEMPLATE PER DOMAIN (or SERVER NAME or IP)
 */
$conf['domains_tmpl'] = array('tolc.lo' => 1,'www.tolc.lo' => 1,'localhost' => 1,'athena' => 1);

/**
 * DATABASE CONNECTION STRING
 */
$conf['dbtype'] = 'mysqlt';
$conf['dbserver'] = 'localhost';
$conf['dbuser'] = 'mos';
$conf['dbpass'] = rawurlencode('suzjimny');
$conf['dbname'] = $conf['domains_db'][$conf['host']];

$conf['dsn_options'] = '?persist=0&fetchmode=2';
$conf['dsn'] = $conf['dbtype'] . '://' . $conf['dbuser'] . ':' . $conf['dbpass'] . '@' . $conf['dbserver'] .'/' .$conf['dbname'] . $conf['dsn_options'];


/**
 * GLOBAL PREFERENCES
 */
/* valid origins */
$conf['valid_origins'] = array('tolc.lo','www.tolc.lo','localhost','athena');

/* error reporting */
$conf['error_reporting'] = 'E_ALL'; //error_reporting(E_ALL);

/* locale */
$conf['pref_default_locale_code'] = 'en_GB';
$conf['pref_default_locale_encoding'] = '.UTF-8';
$conf['pref_default_locale'] = $conf['pref_default_locale_code'] . $conf['pref_default_locale_encoding'];


/* reserved urls */
$conf['pref_reserved_url_login'] = '/login';
$conf['pref_reserved_url_timezone'] = '/timezone';

/* tidy http://tidy.sourceforge.net/docs/quickref.html */
$conf['pref_use_tidy'] = true;
$conf['pref_tidy_config'] =  array('indent' => TRUE,'output-xhtml' => TRUE,'wrap' => 200);
$conf['pref_tidy_encoding'] = 'UTF8';

/* regional settings */
$conf['pref_timezone'] = 'Europe/Athens'; // visitor default timezone

$conf['pref_date_separator'] = '/';
$conf['pref_date_format_datetime_full'] = 'd' . $conf['pref_date_separator'] . 'm' . $conf['pref_date_separator'] . 'Y' . ' ' . 'H:i:s';
$conf['pref_date_format_datetime'] = 'd' . $conf['pref_date_separator'] . 'm' . $conf['pref_date_separator'] . 'Y' . ' ' . 'H:i';
$conf['pref_date_format_date'] = 'd' . $conf['pref_date_separator'] . 'm' . $conf['pref_date_separator'] . 'Y';
$conf['pref_date_format_timestamp_full'] = 'YmdHis';
$conf['pref_date_format_timestamp'] = 'YmdHi';

$conf['pref_decimal_mark'] = ',';
$conf['pref_thousands_separator'] = '.';

/* other */
$conf['pref_autocomplete_rows'] = 10;
?>