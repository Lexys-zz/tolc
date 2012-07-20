<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['locale']))
    $_SESSION['locale'] = $tolc_conf['pref_default_locale'];
$locale = $_SESSION['locale'];
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("tolc", $tolc_conf['project_dir'] . "/app/i18n");
textdomain("tolc");
?>