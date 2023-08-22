<?php
require_once __DIR__ . "/../files/scripts/config.php";

try {
    $adapter -> authenticate();
    $userProfile = $adapter -> getUserProfile();
    print_r($userProfile);
    echo '<br><a href="logout.php">Logout</a>';
}
catch (Exception $e ) {
    echo $e -> getMessage();
}