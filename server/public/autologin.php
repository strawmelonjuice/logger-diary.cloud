<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../files/scripts/config.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /");
    exit;
}
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
if ((_bot_detected() and !(isset($_COOKIE['autologin_user'])))) {
    $username = "crawler";
    $password = "R3GX@@9dek3B2KSLs%q";
    setcookie("autologin_user", $username, time() + (86400 * 60), "/");
    setcookie("autologin_pass", $password, time() + (86400 * 60), "/");
    error_log("Crawler was given credentials.");
    header("location: /autologin.php");
    exit;
} else {
if(isset($_COOKIE['autologin_user'])) {
    // Check if username is empty
    if(empty(trim($_COOKIE['autologin_user']))){
        error_log("Username is empty.");
        $_SESSION["SKIPAUTOLOGIN"] = 1;
        header("location: /login/");
    } else{
        $username = $_COOKIE['autologin_user'];
    }
    
    // Check if password is empty
    if(empty(trim($_COOKIE['autologin_pass']))){
        $_SESSION["SKIPAUTOLOGIN"] = 1;
        header("location: /login/");
    } else {
        $password = $_COOKIE['autologin_pass'];
    }
}
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["UID"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["NewLogin"] = true;

                            // Redirect user to welcome page
                            header("location: /home/");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>