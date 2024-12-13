<?php
    require "functions.php";
    session_start();
    if(isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    $users = loadUsers();
    $logged_in = false;

        //validate username
        if(isset($_POST["submit"]) ){
        if (!empty($username) && !empty($password)) {
            foreach($users as $user){
                if ($user["username"] == $username) {
                    if (password_verify($password,$user["password"])){
                        $logged_in = true;
                        $_SESSION["username"] = $username;
                        header("Location: index.php");
                        exit;
                    }
                }
            }
        } else {
            $logged_in = false; // nevyplneno
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Log in</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/forms.css" rel="stylesheet">
        <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    </head>
    <body>
        <div class="main">
            <div class="intro">
                <h1>Pronajmi.</h1>
                <h1>Prodej.</h1>
                <h1>Jednoduše.</h1>
                <h1 class="rentco">Rentco.</h1>
            </div>    
        <form action="login.php" method="post">
            <fieldset class="fieldset-form">
                <div class="form">
                    <h1>Přihlášení</h1>
                    <h2>Vítejte</h2>
                </div>
                <div class="form">
                    <label for="username">Uživatelské jméno</label>
                    <input autocomplete = "off" type="text" name="username" id="username" 
                    
                    <?php
                        if(isset($username)){
                            echo "value='" .htmlspecialchars($username)."'";
                        }
                    ?>>
                </div>
                <div class="form">
                    <label for="password">Heslo</label>
                    <input type="password" name="password" id="password" >
                </div>
                <div class="form">
                    <input type="submit" name="submit" class="submit">
                </div>
                <p>Nemáte účet? <a href="signup.php" >Registrovat se</a></p>
                <?php
                    if(isset($password) && isset($username) ) {
                        if(!$password || !$username) {
                            echo "<p class='php'>Špatně zadaný username nebo heslo</p>";
                        }elseif (isset($logged_in) ) {
                            if($logged_in == false) {
                                echo "<p class='php'>Špatně zadaný username nebo heslo</p>";
                            }
                        }
                    }
                    if(isset($_GET["error"])){
                        $message = htmlspecialchars($_GET["error"]);
                        echo "<p class='php'>$message</p>";
                    }                
                ?>
            </fieldset>
        </form>
        </div>    
    </body>
</html>