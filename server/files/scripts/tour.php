<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../scripts/AccountInteractions.php");
if ((AccountInteraction($_SESSION['UID'],"Get","others","tour","")) == "true") {
  header("location: /re-tour/");
  die;
}
AccountInteraction($_SESSION['UID'],"Create","","","");
$theme = "taupe";
AccountInteraction($_SESSION['UID'],"Write","others","tour","true");

include(__DIR__."/../pages/tour.php");

?>
