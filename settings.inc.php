<?php
// soubor obsahujici zakladni nastaveni

global $db_server, $db_name, $db_user, $db_pass;
global $web_pagesExtension, $web_pages;

// databaze
    $db_server = "localhost";
    $db_name = "db1_web";
    $db_user = "root";
    $db_pass = "";
    

// stranky webu (ostatni nebudou dostupne)
    $web_pagesExtension = ".php";
    $web_pages[0] = "static";
    $web_pages[1] = "login";
    $web_pages[2] = "user-registration";
    $web_pages[3] = "user-update";
    $web_pages[4] = "user-management";
    $web_pages[5] = "seznam-prispevku";
    $web_pages[6] = "novy-prispevek";
    $web_pages[7] = "prispevky-k-posouzeni";
    $web_pages[8] = "uprava-prispevku";
    $web_pages[9] = "uprava-posudku";
    $web_pages[10] = "seznam-prispevku-admin";
    $web_pages[11] = "posudek-admin";
    $web_pages[12] = "prirazeni-recenze";
    $web_pages[13] = "uprava-uzivatele";
?>