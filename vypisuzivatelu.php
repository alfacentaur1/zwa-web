<?php
    require "functions.php";
    $users = loadUsers();
    print_r($users);
    
//   foreach ($users as &$user) {
//     if ($user['id'] == $id) {
//       $user['name'] = $name;
//       $user["age"] = $age;
//       break;
    print_r($users);
    if (isset($_POST["submit"]) && !empty($users)) {
        foreach ($users as &$user) {
            $username = $user["username"];
            if (isset($_POST[$username])) { // Kontrola, zda klíč existuje
                $user["role"] = $_POST[$username]; // Aktualizace role
            }
        }
        saveRoles($users); // Uložení aktualizovaných uživatelů
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
    print_r($user);
    echo "

        <div class='uzivatel'>
                <p class='underline'>" . ($role == 'admin' ? 'admin' : 'uživatel') . "</p>
                <p>$username</p>

                    <label for=$username>Role</label>
                    <select name='$username' id='$username'>
                        <option value='admin' " . ($role == 'admin' ? 'selected' : '') . ">admin</option>
                        <option value='uzivatel' " . ($role == 'uzivatel' ? 'selected' : '') . ">uživatel</option>
                    </select>
        </div>
    ";
}
?>


<div class='tlacitko'>
<input type='submit' value='potvrdit' class='submit' name="submit">
</form>
</div>
</div>


    
</body>
</html>