<?php
    require_once(__DIR__ . "/../vendor/autoload.php");
    use Symfony\Component\Yaml\Yaml;
    $_ENV = Yaml::parseFile(__DIR__ . '/../config/config.yaml');
    define('DB_SERVER', $_ENV['DB_HOST']);
    define('DB_USERNAME', $_ENV['DB_USERNAME']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);
    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
function _bot_detected()
{

    return (
        isset($_SERVER['HTTP_USER_AGENT'])
        && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $_SERVER['HTTP_USER_AGENT'])
    );
}

    // Check connection
    if($link === false){
        echo "Database seems offline. Try again later.";
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    // $haGoogleAuthconf = ['callback' => 'http://testsite.com:8080/gauth.php',
    // 'keys'     => [
    //     'id' => $_ENV['GLoginID'],
    //     'secret' => $_ENV['GLoginSecret']
    //             ],
    // 'scope'    => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
    // 'authorize_url_parameters' => [
    //         'approval_prompt' => 'force', // to pass only when you need to acquire a new refresh token.
    //         'access_type' => 'offline'
    // ]
    // ];
  
    // $adapter = new Hybridauth\Provider\Google( $haGoogleAuthconf );
?>