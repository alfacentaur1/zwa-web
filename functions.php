<?php 

    // validate username - must be min 6 characters long
    function validate_username($username) {
        if(strlen(trim($username)) < 6 ) {
            return "len"; // return len if too short
        }
        else {return "good";}// return good if the username is valid
    }

    // password validation

    function validate_password($password) {

        $has_no_big = true; // flag for absence of uppercase
        $has_no_special = true;// flag for absence of special chars

        $big_letters = range('A', 'Z');
        $special_characters = ['!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '{', '|', '}', '~'];

        $splitted_password = str_split($password); // split into individual characters


        // check if the password has min 6 length
        if(strlen($password) < 6) {
            return "len";
        } 
        // loop in password for special and big letters
        foreach($splitted_password as $char) {
            if(in_array($char, $big_letters)) {
                $has_no_big = false; // password contains big letter
            }
            if(in_array($char, $special_characters)) {
                $has_no_special = false; // password contains special character
            }
        }

        // no special or big characters
        if ($has_no_big || $has_no_special) {
            return "special";
        }

        return true; // password is valid
        
    }

    // check if 2 passwords are same
    function are_passwords_same($p1, $p2) {
        if($p1===$p2) {
            return true; // they match
        }else {
            return false; // no match
        }
    }

    //email validation
    function validate_email($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  // check if email format is valid
            $domain = substr(strrchr($email, "@"), 1); // extract domain part
            // check if the domain has MX records
            if (!checkdnsrr($domain, "MX")) {
                return false; // Domain does not exist
            }
            return true;  // valid email
        } else {
            return false; // not valid email
        }
    }
    
    // validate all fields in form
    function validate_all($data) {
        foreach ($data as $key => $bit) {
            // check if any field, except "img" is empty or not set
            if($key !== 'img' && (!isset($bit) || empty(trim($bit)))){
                return false;
            }
        }return true; // all fields are valid
    }

    // validate the upload photo format
    function is_right_format($photo) {
        if(($photo["type"] == "image/png"
        || $photo["type"] == "image/jpeg" )){
            return true; // photo is in correct format
        } else {
        return false; // photo format is invalid
        }
    }

    // validate price and size inputs
    function price_size_check($price, $size) {
        // remove spaces and trim inputs
        $price = trim(str_replace(" ", "", $price));
        $size = trim(str_replace(" ", "", $size));
    
        // check if both are numeric and greater than 0
        if (is_numeric($price) && $price > 0 && is_numeric($size) && $size > 0) {
            return true; // both valid
        } else {
            return false; // invalid price or size or both
        }
    }
    // save data to json file
    function addToJson($json,$data) {
        file_put_contents($json,json_encode($data));
    }
    // load users from json file
    function loadUsers() {
        $users = file_get_contents("users.json");
        if (!$users) return []; // if no users, return []
        return json_decode($users, true); // if users exist, decode json into array
    }

    // check if email or username is avalaible
    function isAvalaible($email,$username) {
        $users = loadUsers();
        foreach ($users as $user) {
            if (($user["email"] == $email) || $user["username"] == $username){
                return false; // email or username is taken
            }
        }
        return true; // email and username are avalaible
    }

    // add new user to json
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
    // check if email is unique
    function validEmail($email,$users) {
        foreach ($users as $user) {
            if (($user["email"] == $email)){
                return false; // email is taken
            }
        }
        return true; // email is unique
    }

    // validate if username is unique
    function validUsername($username,$users) {
        foreach ($users as $user) {
            if (($user["username"] == $username)){
                return false; // username exists
            }
        }
        return true; // username is unique
    }

    // authenticate user by username and password
    function userLogin($username,$password,$users) {
        foreach ($users as $user) {
            if($user["password"] == $password && $user["username"] == $username) {
                return true; // user authenticated
            }

        }
        return false; // authentication failed
    }

    // load ads from json
    function loadAds() {
        $ads = file_get_contents("inzeraty.json");
        if (!$ads) return []; // return empty array if file is not found
        return json_decode($ads, true); // decode json into array
    }

    // add a new ad into json
    function addAd($data) {
        $ads = loadAds();
        $ads[] = $data;
        addToJson("inzeraty.json",$ads);
    }

    // update the ads json
    function updateDB($file) {
        $json = json_encode($file);

        $result = file_put_contents("inzeraty.json",$json); //save updated data into json

    }

    // save user roles into json
    function saveRoles($file) {
        $json = json_encode($file);

        $result = file_put_contents("users.json",$json); // save it into json

    }

    // save a single ad into json
    function saveAd($ad){
        $str = json_encode( $ad);
        file_put_contents("inzeraty.json", $str);
      }

    // get the count of items in json
    function getCount($db){
        return count($db);
    }

    // list ads with limit and offset, if not passed give it default values
    function listAds($db,$limit = null, $offset = 0) {
        if ($limit === null) {
            return array_slice($db, $offset); // return all items from the offset
        }
        return array_slice($db, $offset, $limit); // return a limited number of items
    }

    // get user by username
    function getUser($username){
        $users = loadUsers();

        foreach($users as $user){
            if ($user["username"] == $username){
                return $user; //if found return user
            }
        }
    }

?>