<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['locale']))
    $_SESSION['locale'] = PREF_DEFAULT_LOCALE;
$locale = $_SESSION['locale'];
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("tolc", PROJECT_DIR . "/app/i18n");
textdomain("tolc");
?>