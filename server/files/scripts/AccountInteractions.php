<?php
require_once(__DIR__ . "/config.php");

// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 
// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login/");
    exit;
}
use Symfony\Component\Yaml\Yaml;
$uid = $_SESSION['UID'];
function AccountInteraction($UID, string $Action = "Get" | "Write" | "Create", string $Cabinet = "settings" | "entries" | "others", STRING $Name, STRING $Value = NULL) {
    
    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    switch($Action) {
        case "Get":
            $sql = "SELECT `cabinet_". strtolower($Cabinet) . "` FROM `userdata` WHERE `user_id` = " . $UID . "";
            $result = ($conn->query($sql));
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $jsondata = $row["cabinet_".strtolower($Cabinet)];
                $data = json_decode($jsondata,true);
                if ($Value == "all_json") {return $jsondata;}
                if ($Value == "all_array") {return $data;}
                if (array_key_exists($Name, $data)) {
                    return ($data[$Name]);
                } else {
                    return NULL;
                }                
            }
            } else {
            return NULL;
            }
            $conn->close();
            break;
        case "Create":
            $sql = "INSERT INTO `userdata` (`user_id`, `cabinet_settings`, `cabinet_entries`, `cabinet_others`) VALUES ('". $UID . "', '{\"set_theme\":\"taupe\",\"FocusNewEntries\":\"1\",\"LongEntries\":\"0\"}', '[{\\\"Date\\\":\\\"<span class=\'entrytimestamps\'>". time() ."<\\/span>\\\",\\\"Text\\\":\\\"" .  $_SESSION['LANG'][54][7] . "\\\",\\\"Feel\\\":\\\"<span class=\'emojis\'>\\\\ud83c\\\\udf8a<\\/span>\\\"}]', '{\"loginstreak\":\"1\",\"askfordonate\":\"1\"}')";
            $result = ($conn->query($sql));
            $conn->close();
            break;
        case "Write":
            $sql = "SELECT `cabinet_". strtolower($Cabinet) . "` FROM `userdata` WHERE `user_id` = " . $UID . "";
            $result = ($conn->query($sql));
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $jsondata = $row["cabinet_".strtolower($Cabinet)];
                $data = json_decode($jsondata,true);
            }}
            $data[$Name] = $Value;
            $new_json = json_encode($data);
            $sql = "UPDATE `userdata` SET `cabinet_". $Cabinet ."` = '". $new_json ."' WHERE `userdata`.`user_id` = " . $UID;
            $result = ($conn->query($sql));
            $conn->close();
            break;

}
}

function DiaryDot() {
        switch(AccountInteraction($_SESSION['UID'],"Get","settings", "set_theme")) {
            case "hellokitten":
                $DiaryDot = "<span class=\"emojis\">🖤</span>";
                break;
            case "journal":
                $DiaryDot = "✑";
                break;
            case "aurora":
                $DiaryDot = "☄";
                break;
            case "pastellia":
                $DiaryDot = "<span class=\"emojis\">🤍</span>";
                break;
            case "snight":
                $DiaryDot = "<span class=\"emojis\">🌛</span>";
                break;
            case "heartbeat":
                $DiaryDot = "<span class=\"emojis\">💓</span>";
                break;
            default:
                $DiaryDot = ".";
                break;
    }
        return $DiaryDot;
}
function ThemeColor() {
$themeinfo = Yaml::parseFile(__DIR__ . '/../config/themes.yaml'); {
    if ((AccountInteraction($_SESSION['UID'], "Get", "settings", "set_theme")) == 'framework') {
        $chotheme = AccountInteraction($_SESSION['UID'], "Get", "settings", "frameworkmod_theme", "");
    } else {
        $chotheme = (AccountInteraction($_SESSION['UID'], "Get", "settings", "set_theme"));
    }
}
foreach ($themeinfo as $style) {
    if ($style['internal'] == $chotheme) {
        // Match found!
        return $style['color'];
    }
}
}
if (isset($LanguageActionsAvailable) and ($LanguageActionsAvailable )) {
if ((AccountInteraction($_SESSION['UID'],"Get","settings", "PreferedLanguageOverride") != NULL)) {
    unset($_SESSION['UserLangOverride']['lang']);
    foreach(json_decode(file_get_contents(__DIR__ . "/../config/lang/languages.json")) as $result){
            if ((AccountInteraction($_SESSION['UID'],"Get","settings", "PreferedLanguageOverride")) == ($result->langcode)) {
                if (!(AccountInteraction($_SESSION['UID'],"Get","settings", "PreferedLanguageOverride") == $_SESSION['LANG']['code'])) {
                unset($_SESSION['LANG']);
                LoadLang($result->langcode);
    }
    }
}
}
$BMCWidgetSide = "right";
if (AccountInteraction($_SESSION['UID'],"Get","settings", "set_theme") == "framework") {$BMCWidgetSide = "left";}
if (isset($LoggerInfo)) {
if (!(AccountInteraction($_SESSION['UID'],"Get","others", "askfordonate")=="0")) {
$LoggerInfo = $LoggerInfo . '<script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="JustMarOk" data-description="' .  $_SESSION['LANG'][69][1] . '" data-message="'.  $_SESSION['LANG'][69][2] .'" data-color="#'. ThemeColor() .'" data-position="'. $BMCWidgetSide .'" data-x_margin="18" data-y_margin="18"></script>';
}}
}