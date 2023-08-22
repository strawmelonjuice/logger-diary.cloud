<?php
if (file_exists(__DIR__ . "/../MAINTENANCE")) {
    die("Maintenance");
}
if ((!file_exists(__DIR__ . "/../PROD")) and ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1')) {
    echo("this is a testing server. Go to logger-diary.online for the actual web site.");
    header("Location: https://logger-diary.strawmelonjuice.com/");
    die;
}
if (!file_exists(__DIR__ . "/../PROD")) $prod = 0; else $prod = 1;
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";

if (isset($_SESSION['UID']) && ($_SESSION['UID'] != null)) {
    include(__DIR__."/../handleAPIrequest.php");
}
die;