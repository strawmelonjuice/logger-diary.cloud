<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . "/../scripts/AccountInteractions.php");
?>
{
    "short_name": "Logger-Diary",
    "name": "Logger, the simple digital diary.",
    "icons": [
        {
            "src": "/img/logo/icon.ico",
            "sizes": "64x64",
            "type": "image/x-icon"
        },
        {
            "src": "/img/logo/logo_192px.png",
            "type": "image/png",
            "sizes": "192x192"
        },
        {
            "src": "/img/logo/logo_512px.png",
            "type": "image/png",
            "sizes": "512x512"
        }
    ],
    "start_url": "/home/",
    "display": "standalone",
    "scope": "/",
    "background_color": "#<?php echo ThemeColor(); ?>",
    "theme_color": "#<?php echo ThemeColor(); ?>"
}