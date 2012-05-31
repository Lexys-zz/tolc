<?php
if (isset($_GET["locale"])) {
    $locale = $_GET["locale"];
    putenv("LC_ALL=$locale");
    setlocale(LC_ALL, $locale);
    bindtextdomain("test", "./i18n");
    textdomain("test");
}
?>