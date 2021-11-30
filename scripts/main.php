<?php

    ini_set("session.cookie_lifetime",3600 * 24 * 7);
    session_start();
    define('UniProjects','true');
    date_default_timezone_set('Europe/London');
    header('Content-Type: text/html; charset=utf-8');
    mb_internal_encoding('utf-8');

?>