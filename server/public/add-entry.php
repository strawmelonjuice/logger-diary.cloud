<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/files/scripts/config.php";
require_once __DIR__ . "/files/scripts/EntryActions.php";
header('Content-type: application/json');
if ($_POST['StreakCelebration'] = "1") {
    $current = AccountInteraction($_SESSION['UID'],"Get","others", "lastknownclientdate");
    AccountInteraction($_SESSION['UID'],"Write","others","LastStreakCelebration",$current);
}
if (($_SESSION["username"] == "crawler") or ($_SESSION["username"] == "gcrawl")) {
    require_once __DIR__ . "/../files/scripts/EntryPlaceholders.php";
    $new_entry = "[Example used, because this is a crawl account] " . RandomEntryPlaceholder();
} else {
    $new_entry = $_POST['new_entry'];
}
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);
$EntryData = new stdClass();
$EntryData->Date = time();
$EntryData->Text = $Parsedown->text($new_entry);
$EntryData->Feel = htmlspecialchars($_POST['new_entry_feel']);
EntryRW($_SESSION["UID"],"Add", $EntryData);
header("Location: " . $_POST['return']);