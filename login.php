<?php
/**
 * Job: Log users in.
 * 
 * The user fills in the form fields. Upon submission, the input is 
 * validated again. If something is wrong (invalid input), the user is 
 * redirected back to the form with the previously filled-in data (using the
 *  POST superglobal) and an error message. If the data is valid, the user 
 * is redirected to index.php and a SESSION variable is set with the 
 * username under the key "username."
 */
    session_start();
    require "functions.php";
    if(isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
    $users = loadUsers();
    $logged_in = false;

        // Validate username and password (e.g., minimum length, non-empty)
        if (!empty($username) && !empty($password)) {
            foreach($users as $user){
                if ($user["username"] == $username) {
                    if (password_verify($password,$user["password"])){
                        $logged_in = true;
                        // Validation passed, store username in session
                        $_SESSION["username"] = $username;
                        // Redirect to index.php after successful login(PRG)
                        header("Location: index.php");
                        exit();
                    }
            }}}
    }else {
        $logged_in = false; // Not valid
    }


?>
<!DOCTYPE html>
<html lang="cs">
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
                    ?>required>
                </div>
                <div class="form">
                    <label for="password">Heslo</label>
                    <input type="password" name="password" id="password" required>
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
                        $message = urldecode(htmlspecialchars($_GET["error"]));
                        if($message == "1"){
                            echo "<p class='php'>Je nutné přihlášení.</p>";
                        }
                        elseif($message == "2"){
                            echo "<p class='php'>Nemáte práva.</p>";
                        }
                        elseif($message == "3"){
                            echo "<p class='php'>Nastala chyba.</p>";
                        }
                        
                    }                
                ?>
            </fieldset>
        </form>
        </div>    
    </body>
</html>