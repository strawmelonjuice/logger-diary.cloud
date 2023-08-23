<?php

if (file_exists(__DIR__ . "/../MAINTENANCE")) {
    header("HTTP/1.0 500");
    die("Maintenance");
}

if (!str_contains($_SERVER['HTTP_USER_AGENT'], "logger-diary.cloud-client")) die("This is not a place for you, human.");

if (str_starts_with($_SERVER['REQUEST_URI'],"/ping")) {
    die("pong");
}

if (!file_exists(__DIR__ . "/../PROD")) $prod = 0; else $prod = 1;
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../php/config.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../php/config.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($_POST['username'] != $_SESSION['username']) {
        session_destroy();
    } else {
        include(__DIR__."/../handleAPIrequest.php");
        exit;
    }
}
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST['username']))){
        header("HTTP/1.0 401 Unauthorized");
        die("No username.");
    } else{
        $username = trim($_POST['username']);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        header("HTTP/1.0 401 Unauthorized");
        die("No password.");
    } else{
        $password = trim($_POST['password']);
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
                            
                            // If user wants to stay logged in, set cookies (maybe these'll be more encrypted in future but as long as we don't get any cross-site stuff should be good.)
                            if (true) {
                                setcookie("autologin_user", $username, time() + (86400 * 60), "/");
                                setcookie("autologin_pass", $password, time() + (86400 * 60), "/");
                            }
                            // Redirect user to the request handler.
                            include("../handleAPIrequest.php");
                            die;
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
                header("HTTP/1.0 401 Unauthorized");
                die("error");
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
header("HTTP/1.0 401 Unauthorized");
die("Unknown action.");