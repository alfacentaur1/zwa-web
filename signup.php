<?php

    require "functions.php";

    if(isset($_POST["submit"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_znovu = $_POST["password_znovu"];
        $role = $_POST["role"];

        //validace username
        $validated_username = validate_username($username); //"good" kdyz je to spravne, jinak "len"
        $validated_password = validate_password($password); //"len" pri delce, "special" pri znaku jinak true
        $validated_email = validate_email($email); // true kdyz je spravny
        $are_passwords_same = are_passwords_same($password,$password_znovu); //true spravne, false spatne
        $users = loadUsers();
        if(isAvalaible($email,$username) && $validated_email && $are_passwords_same && $validated_password
        &&$validated_username == "good"){
            addUser($email,$username,$password,$role);
            header("Location: index.php");
            exit;
        }
        
    }else {
        //nic
    }

?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Registrace</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/forms.css" rel="stylesheet">
    <script src="js/script.js" defer></script> 
    <script src="js/ajax.js" defer></script> 
</head>
<body>
    <div class="main">
        <div class="intro">
            <h1>Pronajmi.</h1>
            <h1>Prodej.</h1>
            <h1>Jednoduše.</h1>
            <h1 class="rentco">Rentco.</h1>
        </div>
        <form action="signup.php" method="post">
            <fieldset>
                <div class="form">
                    <h1>Registrace</h1>
                    <h2>Vítejte</h2>
                </div>
                <div class="form">
                    <label for="username" >Uživatelské jméno</label>
                    <input type="text" id="username" name="username"
                    <?php
                        if(isset($username)){
                            echo "value='" .htmlspecialchars($username)."'";
                        }
                    ?>
                    required>
                <p class="hidden" id="hidden">username už je obsazené</p>
                </div>
                <div class="form">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                    <?php
                        if(isset($email)){
                            echo "value='" .htmlspecialchars($email)."'";
                        }
                    ?>
                    required >
                </div>
                <input type="hidden" name="role" value="uzivatel">
                <div class="form">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form">
                    <label for="password_znovu">Heslo znovu</label>
                    <input type="password" id="password_znovu" name="password_znovu" required>
                </div>
                <div class="form">
                    <input type="submit" name="submit" class="submit">
                </div>
                <p>Již máte účet? <a href="login.php">Přihlásit se</a></p>
                <p id="error_hesla">Hesla se neshodují</p>
                <?php
                    if(isset($validated_username) && $validated_username !== "good") {
                        if($validated_username == "len") {
                            echo "<p class='php'>Username musí mít minimálně 6 znaků</p>";
                        }elseif($validated_username == "taken") {
                            echo "<p class='php'>Username už je obsazeno</p>";
                        }
                    }
                    if(isset($validated_password) && $validated_password !== true) {
                        if($validated_password == "len") {
                            echo "<p class='php'>Heslo musí mít minimálně 6 znaků</p>";
                        }else{
                            if($validated_password =="special") {
                            echo "<p class='php'>Heslo musí mít min. 1 speciální znak a min. 1 velké písmeno</p>";
                            }
                        }

                    }
                    if(isset($validated_email) && !$validated_email) {
                        if($validated_email == "taken") {
                            echo "<p class='php'>Email už je obsazený</p>";
                        
                        }elseif(!$validated_email) {
                            echo "<p class='php'>Email je ve špatném formátu</p>";
                        }
                    }

                    
                    if(isset($are_passwords_same)){
                        if($are_passwords_same === true) {
                            //nic
                        }else {
                            echo "<p class='php'>Hesla se neshodují</p>"; 
                        }
                    }if(isset($users) && isset($email) && isset($username)){
                        $valid_email = validEmail($email,$users);
                        $valid_username = validUsername($username,$users);
                        if (isset($valid_email)) {
                            if($valid_email != true){
                                echo "<p class='php'>email není dostupný</p>"; 
                            }
                        }
                        if (isset($valid_username)) {
                            if($valid_username != true){
                                echo "<p class='php'>uživatelské jméno není dostupné</p>"; 
                            }
                        }
                    }

                ?>
            </fieldset>
        </form>
    </div>
</body>
</html>