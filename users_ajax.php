<?php
/**
 * Job: Check if username is unique in registration form.
 * The user loads data from the users.json file, then creates an array of 
 * usernames. After that, ajax.js sends an XMLHttpRequest with the username 
 * value, and users_ajax.php returns either the string "used" (taken) or 
 * "not_used" (available). Based on this response, the signup.php will 
 * either show an error message or not.
 */

 require "functions.php";

// Load users from the JSON file
$users = loadUsers();

// Create an array to store usernames
$users_arr = array();
foreach($users as $user) {
    // Check if the "username" key exists in the user data
    if (isset($user["username"])) {
        $users_arr[] = $user["username"];  
    }
}

// Process the request to check if the username is already taken
if (isset($_POST["username"])) {
    // Check if the provided username exists in the $users_arr array
    if (in_array($_POST["username"], $users_arr)) {
        echo "used";  // The username is already taken
    } else {
        echo "not_used";  // The username is available
    }
}
?>