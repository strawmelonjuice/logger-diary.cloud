<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Initialize the session
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    die('not logged in.');
} ELSE {
    require_once __DIR__ . "/../files/scripts/AccountInteractions.php";
}

if (isset($_GET['clientdate'])) {
AccountInteraction($_SESSION['UID'],"Write","others","lastknownclientdate",$_GET['clientdate']);
die(AccountInteraction($_SESSION['UID'],"Get","others","lastknownclientdate"));
}
if ($_POST['focusmode'] == "1") {
AccountInteraction($_SESSION['UID'],"Write","settings","FocusNewEntries","1");
}
if ($_POST['focusmode'] == "0") {
AccountInteraction($_SESSION['UID'],"Write","settings","FocusNewEntries","0");
}
if ($_POST['DisableDailyStreaks'] == "1") {
    AccountInteraction($_SESSION['UID'], "Write", "settings", "DisableDailyStreaks", "1");
}
if ($_POST['DisableDailyStreaks'] == "0") {
    AccountInteraction($_SESSION['UID'], "Write", "settings", "DisableDailyStreaks", "0");
}
if ($_POST['LongEntries'] == "1") {
AccountInteraction($_SESSION['UID'],"Write","settings","LongEntries","1");
}
if ($_POST['LongEntries'] == "0") {
AccountInteraction($_SESSION['UID'],"Write","settings","LongEntries","0");
}
if ($_POST['askfordonate'] == "1") {
AccountInteraction($_SESSION['UID'],"Write","others","askfordonate","1");
}
if ($_POST['askfordonate'] == "0") {
AccountInteraction($_SESSION['UID'],"Write","others","askfordonate","0");
}
if (isset($_GET['set_theme'])) {
    switch ($_GET['set_theme']) {
        case 'jellybean':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme","jellybean");
            break;
        case 'auto':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme","auto");
            break;
        case 'journal':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "journal");
            break;
        case 'rouge':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "rouge");
            break;
        case 'taupe':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "taupe");
            break;
        case 'aurora':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "aurora");
            break;
        case 'skyframe':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "framework");
            AccountInteraction($_SESSION['UID'],"Write","settings","frameworkmod_theme", "skyframe");
            break;
        case 'hellokitten':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "hellokitten");
            break;
        case 'heartbeat':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "heartbeat");
            break;
        case 'pastellia':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "pastellia");
            break;
        case 'pastellia-snight':
            AccountInteraction($_SESSION['UID'], "Write", "settings", "set_theme", "pastellia-snight");
            break;
        case 'plain-light':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "plain-light");
            break;
        case 'plain-dark':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "plain-dark");
            break;
        case 'plain-auto':
            AccountInteraction($_SESSION['UID'], "Write", "settings", "set_theme", "plain-auto");
            break;
        case 'strawmelonjuice-light':
            AccountInteraction($_SESSION['UID'], "Write", "settings", "set_theme", "strawmelonjuice-light");
            break;
        case 'strawmelonjuice-dark':
            AccountInteraction($_SESSION['UID'], "Write", "settings", "set_theme", "strawmelonjuice-dark");
            break;
        case 'snight':
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme", "snight");
            break;
        case 'strawmelonjuice-auto':
            AccountInteraction($_SESSION['UID'], "Write", "settings", "set_theme", "strawmelonjuice-auto");
            break;
    }
}

if (isset($_GET['languageoverride'])) {
    if (($_GET['languageoverride']) == 'auto') {
                AccountInteraction($_SESSION['UID'],"Write","settings","PreferedLanguageOverride", "auto");
                unset($_SESSION['LANG']);
            }
    foreach(json_decode(file_get_contents(__DIR__ . "/../files/config/lang/languages.json")) as $result){
            if (($_GET['languageoverride']) == ($result->langcode)) {
                AccountInteraction($_SESSION['UID'],"Write","settings","PreferedLanguageOverride", $result->langcode);
            }
        }
    }












if (empty($_GET['forward'])) {
    header("Location: /settings/");
} else {
    header("Location: ". $_GET['forward']);
}