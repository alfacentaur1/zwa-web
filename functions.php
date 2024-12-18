<?php
    /**
     * Job: Have the majority of used functions in one file.
     */

    /**
     * Validate username - must be at least 6 characters long.
     * 
     * @param string $username The username to validate.
     * @return string Returns "len" if the username is too short, otherwise "good".
     */
    function validate_username($username) {
        if (strlen(trim($username)) < 6) {
            return "len";
        } else {
            return "good";
        }
    }

    /**
     * Validate password based on length, uppercase, and special characters.
     * 
     * @param string $password The password to validate.
     * @return string|bool Returns "len" if the password is too short, 
     *                     "special" if it lacks uppercase or special characters, 
     *                     or true if valid.
     */
    function validate_password($password) {
        $has_no_big = true;
        $has_no_special = true;

        $big_letters = range('A', 'Z');
        $special_characters = ['!', '"', '#', '$', '%', '&', "'", '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '{', '|', '}', '~'];
        $splitted_password = str_split($password);

        if (strlen($password) < 6) {
            return "len";
        }

        foreach ($splitted_password as $char) {
            if (in_array($char, $big_letters)) {
                $has_no_big = false;
            }
            if (in_array($char, $special_characters)) {
                $has_no_special = false;
            }
        }

        if ($has_no_big || $has_no_special) {
            return "special";
        }

        return true;
    }

    /**
     * Check if two passwords are identical.
     * 
     * @param string $p1 The first password.
     * @param string $p2 The second password.
     * @return bool Returns true if passwords match, false otherwise.
     */
    function are_passwords_same($p1, $p2) {
        return $p1 === $p2;
    }

    /**
     * Validate email address format and domain.
     * 
     * @param string $email The email address to validate.
     * @return bool Returns true if valid, false otherwise.
     */
    function validate_email($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $domain = substr(strrchr($email, "@"), 1);
            if (!checkdnsrr($domain, "MX")) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Validate all form fields except "img".
     * 
     * @param array $data An associative array of form fields.
     * @return bool Returns true if all fields are valid, false otherwise.
     */
    function validate_all($data) {
        foreach ($data as $key => $bit) {
            if ($key !== 'img' && (!isset($bit) || empty(trim($bit)))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the uploaded photo has the correct format.
     * 
     * @param array $photo The photo file data.
     * @return bool Returns true if format is valid, false otherwise.
     */
    function is_right_format($photo) {
        return $photo["type"] === "image/png" || $photo["type"] === "image/jpeg";
    }

    /**
     * Validate price and size inputs.
     * 
     * @param mixed $price The price input.
     * @param mixed $size The size input.
     * @return bool Returns true if both are numeric and greater than 0, false otherwise.
     */
    function price_size_check($price, $size) {
        $price = trim(str_replace(" ", "", $price));
        $size = trim(str_replace(" ", "", $size));

        return is_numeric($price) && $price > 0 && is_numeric($size) && $size > 0;
    }

    /**
     * Save data to a JSON file.
     * 
     * @param string $json The JSON file path.
     * @param array $data The data to save.
     * @return void
     */
    function addToJson($json, $data) {
        file_put_contents($json, json_encode($data));
    }

    /**
     * Load users from a JSON file.
     * 
     * @return array Returns an array of users, or an empty array if no users exist.
     */
    function loadUsers() {
        $users = file_get_contents("users.json");
        return $users ? json_decode($users, true) : [];
    }

    /**
     * Check if email or username is available.
     * 
     * @param string $email The email to check.
     * @param string $username The username to check.
     * @return bool Returns true if both are available, false otherwise.
     */
    function isAvalaible($email, $username) {
        $users = loadUsers();
        foreach ($users as $user) {
            if ($user["email"] === $email || $user["username"] === $username) {
                return false;
            }
        }
        return true;
    }

    /**
     * Add a new user to the JSON file.
     * 
     * @param string $email The user's email.
     * @param string $username The user's username.
     * @param string $password The user's password.
     * @param string $role The user's role.
     * @return void
     */
    function addUser($email, $username, $password, $role) {
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

        /**
     * Check if email is unique.
     * 
     * @param string $email The email to validate.
     * @param array $users The list of users to check against.
     * @return bool Returns true if the email is unique, false otherwise.
     */
    function validEmail($email, $users) {
        foreach ($users as $user) {
            if (($user["email"] == $email)) {
                return false; // email is taken
            }
        }
        return true; // email is unique
    }

    /**
     * Validate if username is unique.
     * 
     * @param string $username The username to validate.
     * @param array $users The list of users to check against.
     * @return bool Returns true if the username is unique, false otherwise.
     */
    function validUsername($username, $users) {
        foreach ($users as $user) {
            if (($user["username"] == $username)) {
                return false; // username exists
            }
        }
        return true; // username is unique
    }

    /**
     * Authenticate a user by username and password.
     * 
     * @param string $username The username to authenticate.
     * @param string $password The password to authenticate.
     * @param array $users The list of users to check against.
     * @return bool Returns true if the user is authenticated, false otherwise.
     */
    function userLogin($username, $password, $users) {
        foreach ($users as $user) {
            if ($user["password"] == $password && $user["username"] == $username) {
                return true; // user authenticated
            }
        }
        return false; // authentication failed
    }

    /**
     * Load ads from the JSON file.
     * 
     * @return array Returns an array of ads or an empty array if the file is not found.
     */
    function loadAds() {
        $ads = file_get_contents("inzeraty.json");
        if (!$ads) return []; // return empty array if file is not found
        return json_decode($ads, true); // decode json into array
    }

    /**
     * Add a new ad to the JSON file.
     * 
     * @param array $data The ad data to add.
     * @return void
     */
    function addAd($data) {
        $ads = loadAds();
        $ads[] = $data;
        addToJson("inzeraty.json", $ads);
    }

    /**
     * Update the ads JSON file.
     * 
     * @param array $file The updated data to save.
     * @return void
     */
    function updateDB($file) {
        $json = json_encode($file);
        $result = file_put_contents("inzeraty.json", $json); // save updated data into json
    }

    /**
     * Save user roles into the users JSON file.
     * 
     * @param array $file The updated user roles data.
     * @return void
     */
    function saveRoles($file) {
        $json = json_encode($file);
        $result = file_put_contents("users.json", $json); // save it into json
    }

    /**
     * Save a single ad to the JSON file.
     * 
     * @param array $ad The ad data to save.
     * @return void
     */
    function saveAd($ad) {
        $str = json_encode($ad);
        file_put_contents("inzeraty.json", $str);
    }

    /**
     * Get the count of items in a database (array).
     * 
     * @param array $db The database to count items from.
     * @return int Returns the number of items in the database.
     */
    function getCount($db) {
        return count($db);
    }

    /**
     * List ads with a limit and offset.
     * 
     * @param array $db The database of ads.
     * @param int|null $limit The maximum number of ads to return (optional).
     * @param int $offset The starting point for listing ads (default is 0).
     * @return array Returns a subset of ads based on the limit and offset.
     */
    function listAds($db, $limit = null, $offset = 0) {
        if ($limit === null) {
            return array_slice($db, $offset); // return all items from the offset
        }
        return array_slice($db, $offset, $limit); // return a limited number of items
    }

    /**
     * Get a user by their username.
     * 
     * @param string $username The username to search for.
     * @return array|null Returns the user data if found, or null if not found.
     */
    function getUser($username) {
        $users = loadUsers();
        foreach ($users as $user) {
            if ($user["username"] == $username) {
                return $user; // if found, return user
            }
        }
    }
?>