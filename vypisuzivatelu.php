<?php
    require "functions.php";
    require "header.php";
    if(!isset($_SESSION["username"])||!isset($current_user) || $current_user["role"] != "admin"){
        $message = "nemate_povoleni";
        header("Location: login.php?error=$message");
    }

    if (isset($_POST["submit"]) && !empty($users)) {
        foreach ($users as &$user) {
            $username = $user["username"];
            if (isset($_POST[$username])) { // Kontrola, zda klíč existuje
                $user["role"] = $_POST[$username]; // Aktualizace role
            }
        }
        saveRoles($users);
        $users = loadUsers();
        header("Location: index.php?php=uspesne zmeneno");
        // Uložení aktualizovaných uživatelů
    }

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Výpis uživatelů</title>
    <link rel="stylesheet" href="css/vypisuzivatelu.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
</head>
<body>
<?php require "nav.php" ?>
<div id='container-uzivatelu'>
<div class='form'>
<form action='vypisuzivatelu.php' method='post'>
<?php 

foreach ($users as $user) {
    $id = htmlspecialchars($user["id"]);
    $username = htmlspecialchars($user["username"]); 
    $role = htmlspecialchars($user["role"]); 
    echo "

        <div class='uzivatel'>
                <p class='underline'>" . ($role == 'admin' ? 'admin' : 'uživatel') . "</p>
                <p>$username</p>

                    <label for=".trim($id).">Role</label>
                    <select name='$username' id='".trim($id)."'>
                        <option value='admin' " . ($role == 'admin' ? 'selected' : '') . ">admin</option>
                        <option value='uzivatel' " . ($role == 'uzivatel' ? 'selected' : '') . ">uživatel</option>
                    </select>
        </div>
    ";
}
?>


<div class='tlacitko'>
<input type='submit' value='potvrdit' class='submit' name="submit">
</div>
</form>
</div>
</div>


    
</body>
</html>