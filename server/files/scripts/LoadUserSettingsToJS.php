<?php
    require_once(__DIR__ . '/AccountInteractions.php');
    if ((AccountInteraction($_SESSION['UID'],"Get","settings","zoomdiffer","")) == "") {
        AccountInteraction($_SESSION['UID'],"Write","settings","zoomdiffer","0");
        $zoomdiffer = '0';
    } else {
        $zoomdiffer = AccountInteraction($_SESSION['UID'],"Get","settings","zoomdiffer","");
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
?>
    <script>
        var usersetting = JSON.parse(`<?php echo(json_encode($_SESSION["usersetting"])) ?>`);
    </script>