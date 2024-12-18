<?php
/**
 * Job: Template for getting user object from json
 * Start session, then load users, by getUser function get current user.
 */
    session_start();
    require_once "functions.php";
    $users = loadUsers();
    $current_user = null;
    if(isset($_SESSION["username"])){
        $current_user = getUser($_SESSION["username"]);
}

?>