<?php
if (file_exists(__DIR__ . "/../MAINTENANCE")) {
    header("Location: /maintenance.html");
    die();
}
if ((!file_exists(__DIR__ . "/../PROD")) and ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1')) {
    echo("this is a testing server. Go to logger-diary.online for the actual web site.");
    header("Location: https://logger-diary.strawmelonjuice.com/");
    die;
}
if (!file_exists(__DIR__ . "/../PROD")) $prod = 0; else $prod = 1;
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Detect electron users!
if (isset($_GET["clientapp"])) {
    if ($_GET["clientapp"] == "electron") {
        $_SESSION["electronclient"] = "1";
    }
}
function ElectronApp()
{
    if ((isset($_SESSION["electronclient"])) && ($_SESSION["electronclient"] == 1)) {
        return true;
    } else
        return false;
}
$url = strtok($_SERVER['REQUEST_URI'], '?');
//      We will always need a trailing slash, or the script won't recognise requested sources
$url .= (substr($url, -1) == '/' ? '' : '/');
if (isset($_GET['api']) and ($_GET['api'] != null)) {
    header('Cache-Control: max-age=0, must-revalidate');
    switch ($_GET['api']) {
        case 'entries-json':
            header('Content-type: application/json');
            require_once __DIR__ . "/../files/scripts/EntryActions.php";
            echo (EntryRW($_SESSION["UID"], "Get"));
            die;
        case 'manifest':
            header('Content-type: application/json');
            if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                echo (file_get_contents(__DIR__ . "/../files/pwa_manifest.json"));
            } else {
                include(__DIR__ . "/../files/scripts/pwa_manifest.php");
            }
            die;
    }
}
switch ($url) {
    case '/feed/':
    case '/atom/':
    case '/rss/':
        header("Content-type: text/xml; charset=utf-8");
        echo shell_exec('curl https://strawmelonjuice.com/feed?cat=Logger-Diary+Online');
        die;
}
require_once(__DIR__ . "/../files/scripts/LanguageActions.php");
if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
require_once(__DIR__ . "/../files/scripts/AccountInteractions.php");
}
if (str_starts_with($url,"/lang")) {
    if ($_GET["id"] != null) {
        die($_SESSION['LANG'][$_GET["id"]]);
    } else if ($_GET["1"] != null) {
        if ($_GET["3"] != null) {
            die($_SESSION['LANG'][$_GET["1"]][$_GET["2"]][$_GET["3"]]);
        } else {
            die($_SESSION['LANG'][$_GET["1"]][$_GET["2"]]);
        }
    }
}
// I walked into that, too. Run:
// sudo git config --system --add safe.directory /srv/ldcloud
// first.
$last_commit_TS = trim((shell_exec('git log -1 --format=%ct ')));
$last_commit_ID = trim((shell_exec('git rev-parse --short HEAD')));
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $LoggerInfo = <<<LOL
        Logger-Diary Cloud Edition, last updated: <CODE id='lastupdatedate' onmouseover='ParseMyTimeStamp()'
        style='filter: blur(5px)'>{$last_commit_TS}</CODE> with commit ID:
        <CODE><a href='https://github.com/logger-diary/cloud/commit/{$last_commit_ID}'>{$last_commit_ID}</a></CODE>. Not logged
        in. Request URI: <CODE>{$url}</CODE>.

        <script>
        setTimeout(() => { ParseThisTimeStamp('lastupdatedate') }, 1500);
        const urisrvside = '{$url}';
        </script>
    LOL;
} else {
    $LoggerInfo = <<<LEL
        {$_SESSION['LANG'][31]} <CODE id='lastupdatedate' onmouseover='ParseMyTimeStamp()'
        style='filter: blur(5px)'>{$last_commit_TS}</CODE> {$_SESSION['LANG'][32]}
    <CODE><a href='https://github.com/logger-diary/cloud/commit/{$last_commit_ID}'>{$last_commit_ID}</a></CODE>. UserID:
    <CODE>{$_SESSION['UID']}</CODE>. Request URI: <CODE>{$url}</CODE>.
    <script>
        setTimeout(() => { ParseThisTimeStamp('lastupdatedate') }, 1500);
        const urisrvside = '{$url}';
    </script>
    LEL;
}

echo "<!-- You are here: '" . $url . "' -->";

switch (strtolower($url)) {
    case '/':
        include(__DIR__ . "/../files/pages/landing.php");
        break;
    case '/home/':
        include(__DIR__ . "/../files/pages/home.php");
        break;
    case '/settings/':
        include(__DIR__ . "/../files/pages/settings.php");
        break;
    case '/themes/':
        include(__DIR__ . "/../files/pages/themeselector.php");
        break;
    case '/logout/':
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        setcookie("autologin_user", NULL, time() - 13600, "/");
        setcookie("autologin_pass", NULL, time() - 13600, "/");
        // try {
        //     if ($adapter->isConnected()) {
        //         $adapter->disconnect();
        //         echo 'Logged out the user';
        //         echo '<p><a href="index.php">Login</a></p>';
        //     }
        // }
        // catch( Exception $e ){
        //     echo $e->getMessage() ;
        // }
        $_SESSION = array();
        session_destroy();
        header("location: /login/");
        break;
    case '/login/':
        include(__DIR__ . "/login.php");
        break;
    case '/register/':
        include(__DIR__ . "/register.php");
        break;
    case '/re-tour/':
        include(__DIR__ . "/../files/pages/tour.php");
        break;
    case '/tour/':
        include(__DIR__ . "/../files/scripts/tour.php");
        break;
    case '/news/':
        header("Location: http://strawmelonjuice.com/?c=Logger-Diary%20Online");
        break;
    case '/contributions/':
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            include(__DIR__ . "/../files/pages/contributors-a.php");
        } else {
            include(__DIR__ . "/../files/pages/contributors-b.php");
        }
        break;
    case '/license/':
    case '/licence/':
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            include(__DIR__ . "/../files/pages/licence-a.php");
        } else {
            include(__DIR__ . "/../files/pages/licence-b.php");
        }
        break;
    default:
        http_response_code(404);
        include(__DIR__ . "/../files/pages/404.php");
}
die;