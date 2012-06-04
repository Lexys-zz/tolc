<?php
if (isset($_SESSION["locale"])) {
    $locale = $_SESSION["locale"];
    //$locale = 'el_GR.UTF-8';
    putenv("LC_ALL=$locale");
    setlocale(LC_ALL, $locale);
    bindtextdomain("tolc", PROJECT_DIR . "/app/i18n");
    textdomain("tolc");
}
?>