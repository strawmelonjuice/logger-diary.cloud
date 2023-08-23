<?php
if (isset($_POST['ask']) and ($_POST['ask'] != null)) {
    header('Cache-Control: max-age=0, must-revalidate');
    switch ($_POST['ask']) {
        case 'entries':
            header('Content-type: application/json');
            require_once __DIR__ . "/files/scripts/EntryActions.php";
            echo (EntryRW($_SESSION["UID"], "Get"));
            die;
        case 'settings':
            require_once(__DIR__ . "/files/scripts/AccountInteractions.php");
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
            echo json_encode(array(
                'test' => 'passed',
            ));
    }
}
die();
