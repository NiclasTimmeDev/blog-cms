<?php

declare(strict_types=1);

require_once("config/config.php");
require_once("config/secrets.php");
require_once("helpers/view_helpers.php");
require_once("helpers/url_helper.php");
require_once("helpers/session_helper.php");

spl_autoload_register(function ($className) {
    $filepath = "../app/libs/" . $className . ".php";
    if (!file_exists($filepath)) {
        echo $className . ".php not found";
        return false;
    } else {
        require_once($filepath);
    }
});