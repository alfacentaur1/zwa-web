<?php
/**
 * Job: Show details about users profile(users current session). 
 * 
 * The user can only access the page if they are logged in. Once logged in,
 * the user is found in the users.json file using the username key from the 
 * global $_SESSION variable, and the user details (username, email, role) 
 * are displayed from the JSON file.
 */
    require "header.php";
    // If there is no users session, redirect him to login
    if(!isset($_SESSION["username"])){
        $message = urlencode("1");
        header("Location: login.php?error=$message");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
</head>
<body>
<?php 
    require "nav.php" ;

?>
    <div class="upper-container">
        <div class="main-container">
            <div>
                <p class="underline">Uživatelské jméno</p>
                <p><?=htmlspecialchars($current_user["username"])?></p>
            </div>
            <div>
                <p class="underline">Email</p>
                <p><?=htmlspecialchars($current_user["email"])?></p>
            </div>
            <div>
                <p class="underline">Role</p>
                <p><?=htmlspecialchars($current_user["role"])?></p>
            </div>
        </div>
    </div>
</body>
</html>