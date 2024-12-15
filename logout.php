<?php
    // just destroy current session
    session_start();
    if(!isset($_SESSION["username"])){
        $message = urlencode("Nemáte práva.");
        header("Location: login.php?error=$message");
        exit;
    }
    $_SESSION = array();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
    header("Location: login.php");
    exit;
?>