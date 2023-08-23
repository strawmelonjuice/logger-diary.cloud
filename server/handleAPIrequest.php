<?php
if (isset($_POST['ask']) and ($_POST['ask'] != null)) {
    header('Cache-Control: max-age=0, must-revalidate');
    switch ($_POST['ask']) {
        case 'entries':
            header('Content-type: application/json');
            require_once __DIR__ . "/php/EntryActions.php";
            echo (EntryRW($_SESSION["UID"], "Get"));
            break;
        case 'settings':
            require_once(__DIR__ . "/php/AccountInteractions.php");
            if ((AccountInteraction($_SESSION['UID'], "Get", "settings", "zoomdiffer", "")) == "") {
                AccountInteraction($_SESSION['UID'], "Write", "settings", "zoomdiffer", "0");
                $zoomdiffer = '0';
            } else {
                $zoomdiffer = AccountInteraction($_SESSION['UID'], "Get", "settings", "zoomdiffer", "");
            }
            if ((AccountInteraction($_SESSION['UID'], "Get", "settings", "relativetimes", "")) == "") {
                AccountInteraction($_SESSION['UID'], "Write", "settings", "relativetimes", "1");
                $relativetimes = 1;
            } else {
                $relativetimes = AccountInteraction($_SESSION['UID'], "Get", "settings", "relativetimes", "");
            }
            if (AccountInteraction($_SESSION["UID"], "Get", "settings", "LongEntries", "") == "0") {
                $longEntries = false;
            } else {
                $longEntries = true;
            }
            $_SESSION["usersetting"] = array(
                "relativetimes" => $relativetimes,
                "zoomdiffer" => $zoomdiffer,
                "longEntries" => $longEntries,
            );

            echo (json_encode($_SESSION["usersetting"]));
            break;
        case 'access':
            echo json_encode(
                array(
                    'test' => 'passed',
                )
            );
            break;
        case 'addentry':
            require_once __DIR__ . "/vendor/autoload.php";
            require_once __DIR__ . "/php/config.php";
            require_once __DIR__ . "/php/EntryActions.php";
            header('Content-type: application/json');
            if ($_POST['StreakCelebration'] = "1") {
                $current = AccountInteraction($_SESSION['UID'], "Get", "others", "lastknownclientdate");
                AccountInteraction($_SESSION['UID'], "Write", "others", "LastStreakCelebration", $current);
            }
            $new_entry = $_POST['new_entry'];
            $Parsedown = new Parsedown();
            $Parsedown->setSafeMode(true);
            $EntryData = new stdClass();
            $EntryData->Date = time();
            $EntryData->Text = $Parsedown->text($new_entry);
            $EntryData->Feel = htmlspecialchars($_POST['new_entry_feel']);
            EntryRW($_SESSION["UID"], "Add", $EntryData);
            break;
    }
}
die();