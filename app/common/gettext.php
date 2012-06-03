<?php
if (isset($_SESSION["locale"])) {
    $locale = $_SESSION["locale"];
    putenv("LC_ALL=$locale");
    setlocale(LC_ALL, $locale);
    bindtextdomain("tolc", "./i18n");
    textdomain("tolc");
}
?>