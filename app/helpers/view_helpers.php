<?php

// HEADER
function get_header()
{
    require_once(APPROOT . "/views/includes/header.php");
}

// FOOTER
function get_footer()
{
    require_once(APPROOT . "/views/includes/footer.php");
}

//NAVBAR
function get_navbar()
{
    require_once(APPROOT . "/views/includes/navbar.php");
}

// INCLUDE SPECIFIC JS FILE
function include_js($filename, $url)
{
    $current_url = $_GET["url"];
    if ($url == $current_url) {
        echo "<script src=" .  URLROOT . "/js/" . $filename . "></script>";
    }
}