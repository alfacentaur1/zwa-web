<?php
    require "functions.php";

    // Načtěte uživatele z JSON souboru
    $users = loadUsers();
    

    // Vytvořte pole s uživatelskými jmény
    $users_arr = array();
    foreach($users as $user) {
        if (isset($user["username"])) {
            $users_arr[] = $user["username"];  // Přidejte každé uživatelské jméno
        }
    }


    // Zpracování požadavku na ověření uživatelského jména
    if (isset($_POST["username"])) {
        if (in_array($_POST["username"], $users_arr)) {
            echo "used";  // Uživatelské jméno je obsazeno
        } else {
            echo "not_used";  // Uživatelské jméno není obsazeno
        }
    }
?>