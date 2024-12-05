<?php 

    //validace username

    function validate_username($username) {
        if(strlen(trim($username)) < 6 ) {
            return "len";
        }
        // if($username in db) {
        //     //username already in db
        // }

        //all is good
        else {return "good";}
    }

    //password validation

    function validate_password($password) {

        $has_no_big = true;
        $has_no_special = true;

        $big_letters = range('A', 'Z');
        $special_characters = ['!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '{', '|', '}', '~'];

        $splitted_password = str_split($password);


        //nema pozadovanou delku
        if(strlen($password) < 6) {
            return "len";
        } 
        //loop in password for special and big letters
        foreach($splitted_password as $char) {
            if(in_array($char, $big_letters)) {
                $has_no_big = false;
            }
            if(in_array($char, $special_characters)) {
                $has_no_special = false;
            }
        }

        //no special chars or big
        if ($has_no_big || $has_no_special) {
            return "special";
        }


        return true;

        
    }

    //validace shodnosti hesel
    function are_passwords_same($p1, $p2) {
        if($p1===$p2) {
            return true;
        }else {
            return false;
        }
    }

    //validace emailu - validní - true, nevalidní - false
    function validate_email($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;  
        } else {
            return false; 
        }
    }
    


    //validation in addform

    //inputy nejsou empty

    function validate_all($data) {
        foreach ($data as $key => $bit) {
            if($key !== 'img' && (!isset($bit) || empty(trim($bit)))){
                return false;
            }
        }return true;
    }

    //validace foto true kdyz je spravne
    function is_right_format($photo) {
        if(($photo["type"] == "image/png"
        || $photo["type"] == "image/jpeg" )){
            return true;
        } else {
        return false;
        }
    }

    //validace cena
    function price_size_check($price, $size) {
        // trim odstrani mezery kolem textu
        $price = trim(str_replace(" ", "", $price));
        $size = trim(str_replace(" ", "", $size));
    
        // kontrolujeme jeslti jsou to cisla a vetsi nez 0
        if (is_numeric($price) && $price > 0 && is_numeric($size) && $size > 0) {
            return true; // platne
        } else {
            return false; 
        }
    }
    function addToJson($json,$data) {
        file_put_contents($json,json_encode($data));
    }
    function loadUsers() {
        $users = file_get_contents("users.json");
        if (!$users) return [];
        return json_decode($users, true);
    }

    //kdyz je to v jsonu dostupne(mail, username) tak vrat true
    function isAvalaible($email,$username) {
        $users = loadUsers();
        foreach ($users as $user) {
            if (($user["email"] == $email) || $user["username"] == $username){
                return false;
            }
        }
        return true;
    }

    //pridame usera, kdyz to jde, vratime true, jinak vratime false
    function addUser($email,$username,$password,$role) {
        $users = loadUsers();
        
        
        $users[] = [
            "id" => uniqid(),
            "email" => $email,
            "username" => $username,
            "password" => $password,
            "role" => $role
        ];
        addToJson("users.json", $users);
        
    }

    function validEmail($email,$users) {
        foreach ($users as $user) {
            if (($user["email"] == $email)){
                return false;
            }
        }
        return true;
    }
    function validUsername($username,$users) {
        foreach ($users as $user) {
            if (($user["username"] == $username)){
                return false;
            }
        }
        return true;
    }

    function userLogin($username,$password,$users) {
        foreach ($users as $user) {
            if($user["password"] == $password && $user["username"] == $username) {
                return true;
            }

        }
        return false;
    }
    function loadAds() {
        $ads = file_get_contents("inzeraty.json");
        if (!$ads) return [];
        return json_decode($ads, true);
    }

    function addAd($data) {
        $ads = loadAds();
        $ads[] = $data;
        addToJson("inzeraty.json",$ads);
    }

    function updateDB($file) {
        //global $db;
        $json = json_encode($file);

        $result = file_put_contents("inzeraty.json",$json);


    }

    function saveRoles($file) {
        //global $db;
        $json = json_encode($file);

        $result = file_put_contents("users.json",$json);


    }

    function saveAd($ad){
        $str = json_encode( $ad);
        file_put_contents("inzeraty.json", $str);
      }



?>