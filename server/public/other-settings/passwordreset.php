<?php
// Initialize the session
$last_commit_ID = trim((shell_exec('git rev-parse --short HEAD')));
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../../files/scripts/AccountInteractions.php");
require_once(__DIR__ . "/../../files/scripts/EntryPlaceholders.php");
if (!(AccountInteraction($_SESSION['UID'],"Get","others","tour","")) == "true") {
  header("location: /tour/");
}

      {
        // If no theme is set, and no theme is known, just fall back to taupe theme.
        if (empty(AccountInteraction($_SESSION['UID'],"Get","settings", "set_theme"))) {
            AccountInteraction($_SESSION['UID'],"Write","settings","set_theme","taupe");
            $theme = "taupe";
        } else {
          $theme = AccountInteraction($_SESSION['UID'],"Get","settings", "set_theme");
        }
    }
    // Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (($_SESSION["username"] == "crawler") or ($_SESSION["username"] == "gcrawl")) {
        header("Location: /logout/");
    }
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: /logout/");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['LANG']['code']; ?>">

<head>
      <?php if ($prod) {
  echo ("<script src=\"https://cdn.jsdelivr.net/gh/strawmelonjuice/Logger-Diary.Online@{$last_commit_ID}/public/js/early.min.js\"></script>");
} else {
  echo "<script src=\"/js/early.js\"></script>";
}?>
    <meta name="theme-color" content="#<?php echo ThemeColor(); ?>" />
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="/img/logo/icon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(__DIR__ . "/../scripts/themeload.php");
  include(__DIR__. "/../scripts/LoadUserSettingsToJS.php");
?>
    <title>Logger-Diary&nbsp;Online&nbsp;-&nbsp;Reset&nbsp;password</title>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>

<body>
    <div id="theLoggerNav" class="sidenav"><a href="javascript:void(0)" class="closebtn" onclick="doHideNav()">&times;</a>
        <a href="/home/"><span class="emojis">🏠</span>&nbsp;<?php Echo $_SESSION['LANG'][6]; ?></a>
        <a href="/news/"><span class="emojis">🗞️</span>&nbsp;<?php Echo $_SESSION['LANG'][9]; ?></a>
        <a href="/logout/"><span class="emojis">🚪</span>&nbsp;<?php Echo $_SESSION['LANG'][48]; ?></a>
        <!-- <?php   echo "<a href=\"javascript:void(0)\" id=\"mmlt\" style=\"display: block;\" onclick=\"moreLinks()\">➕{$_SESSION['LANG'][66]}...</a>"; ?>
        <div style="display: none;" id="menumorelinks"><a href="javascript:void(0)" onclick="lessLinks()">➖ <?php Echo $_SESSION['LANG'][67]; ?></a></div> -->
    </div>
    <span id="ViewNavButtonSpan"><button onclick="doViewNav()" type="button" id="ViewNavButton">&#9776;</button></span>
    <div id="main">
        <h1>Logger-Diary Online<?php echo DiaryDot(); ?></h1>
        <h5><div class="bymarbanner"><?php Echo $_SESSION['LANG'][3]; ?>&nbsp;<a class="bymarbanner" href="/contributions/"><?php Echo $_SESSION['LANG'][4]; ?></a></div></h5>
        <h3><?php Echo $_SESSION['LANG'][7]; ?></h3>
        <div class="AddEntryForm">
            <h4>Reset Password</h4>
            <p align="center">Please fill out this form to reset your password.</p>
        </div>
        <div class="readback settingsmain" align="center">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="LoginForm <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="LoginForm <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="LoginForm LoginButton" value="Submit">
                <a class="btn btn-link ml-2 LoginForm LoginButton" href="/settings/">Cancel</a>
            </div>
        </form>
        </div>
        <footer class="infofooter">
            <hr>
            <p><?php echo $LoggerInfo; ?></p>
        </footer>
    </div>
<?php
if ($prod) {
  echo ("<script src=\"https://cdn.jsdelivr.net/combine/gh/strawmelonjuice/Logger-Diary.Online@{$last_commit_ID}/public/js/site.min.js,gh/strawmelonjuice/Logger-Diary.Online@{$last_commit_ID}/public/js/theme.min.js,npm/hl-img@{$_ENV['HLimgVersion']}/hl-img.min.js\"></script>");
} else {
  echo <<<YEAG
  <script src="/js/site.js"></script>
  <script defer src="/js/theme.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/hl-img@latest/hl-img.js"></script>
  YEAG;
}
?>
</body>
</html>