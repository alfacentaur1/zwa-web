<?php
/**
 * Job: Role management for admins.
 * 
 * If the user is not logged in or is not an admin, they will be redirected
 *  to the login page. If the user is an admin, a list of users will be 
 * displayed using a foreach loop that processes users.json. For each user,
 *  a select dropdown will show their current role. If the admin wants to 
 * change the role, they can simply select a new role and submit the form. 
 * The selected role will then be updated in users.json via the POST data, 
 * and the page will redirect to index.php.
 */
    require "functions.php";
    require "header.php";
    // Check if the user is logged in and has admin rights
    if (!isset($_SESSION["username"]) || !isset($current_user) || $current_user["role"] != "admin") {
        $message = urlencode("2");  
        header("Location: login.php?error=$message");  
        exit();  
    }

    // If the form is submitted and there are users to process
    if (isset($_POST["submit"]) && !empty($users)) {
        // Loop through each user to update their role
        foreach ($users as &$user) {
            $id = $user["id"];  
            if (isset($_POST[$id])) {  
                $user["role"] = $_POST[$id];  // Update users role
            }
        }
    saveRoles($users);  // Save the updated users data with the new roles
    $users = loadUsers();  // Reload the users from the JSON file
    header("Location: index.php");  
    exit();  
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
    $username = htmlspecialchars(($user["username"]));
    $role = htmlspecialchars($user["role"]); 
    echo "

        <div class='uzivatel'>
                <p class='underline'>" . ($role == 'admin' ? 'admin' : 'uživatel') . "</p>
                <p>$username</p>

                    <label for=".trim($id).">Role</label>
                    <select name='$id' id='".trim($id)."'>
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