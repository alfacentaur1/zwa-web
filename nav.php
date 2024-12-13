<!-- template for nav -->
<div class="nav">
        <nav>
            <h1>Rentco.</h1>
            <ul>
                <li><a href="index.php">Domů</a></li>
                <li><a href="addform.php">Přidat</a></li>
                <li><a href="profil.php">Profil</a></li>
            </ul>
            <ul>
            <?php if(isset($_SESSION["username"]) && isset($current_user)){
            echo'
                <li class="odkazy"><a href="logout.php">Odhlásit</a></li>';
            }
                
                 if(!isset($_SESSION["username"]) && !isset($current_user)){
                echo '
                <li class="odkazy"><a href="login.php">Přihlásit</a></li>
                <li class="odkazy"><a href="signup.php">Registrovat</a></li>';
                }
                 if(isset($_SESSION["username"]) && isset($current_user)&&$current_user["role"] == "admin"){
                    echo '<li class="odkazy"><a href="vypisuzivatelu.php" class="a-role">Role</a></li>';
                }?>
                
            </ul>
            <?php 
            if(isset($_SESSION["username"])){
                $message = $current_user["username"];
                echo "
                <p id='user'>uživatel přihlášen jako: $message</p>
                ";
            }
            ?>
        </nav>
</div>