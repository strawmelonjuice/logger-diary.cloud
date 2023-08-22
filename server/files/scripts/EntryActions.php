<?php
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/AccountInteractions.php");
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login/");
    exit;
}
function EntryRW($UID, string $Action = "Get" | "Add", $Value = NULL) {
    
    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    switch($Action) {
        case "Get":
            $sql = "SELECT `cabinet_entries` FROM `userdata` WHERE `user_id` = " . $UID . "";
            $result = ($conn->query($sql));
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row["cabinet_entries"];
            }
            } else {
            return "";
            }
            $conn->close();
            break;
        case "Set":
            $data_json = json_encode($Value);
            $sql = "UPDATE `userdata` SET `cabinet_entries` = (`". $data_json ."`) WHERE `userdata`.`user_id` = " . $UID;
            die($sql);
            $result = (($conn)->query($sql));
            break;
        break;
        case "Add":
            $sql = "SELECT `cabinet_entries` FROM `userdata` WHERE `user_id` = " . $UID . "";
            $result = ($conn->query($sql));
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $jsondata = $row["cabinet_entries"];
                $data = json_decode($jsondata,true);
            }}
            array_unshift($data , $Value);
            $new_json = json_encode($data);
            $readied_json = str_replace('"Feel":"<span class=\'emojis\'>\\u2026<\\/span>"},', '"Feel":"<span class=\'emojis\'>&#9210;<\\/span>"},', $new_json);
            // die($readied_json);
            $sql = "UPDATE `userdata` SET `cabinet_entries` = \"". addslashes($readied_json) ."\" WHERE `userdata`.`user_id` = " . $UID;
            // die($sql);
            $result = ($conn->query($sql));
            $conn->close();
            break;
}}