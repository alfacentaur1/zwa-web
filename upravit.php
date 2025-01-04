<?php
/**
 * Job: Update ad in json database.
 * 
 * This page can be accessed through a link in the ad details. The user must
 *  be logged in and must be the owner of the ad to be able to edit it. This
 *  is checked using the SESSION global variable. The ad's ID is then 
 * retrieved from the GET variable, which is used to identify the ad in 
 * inzeraty.json. If the ad doesn't exist, the user is redirected to the 
 * index page. If the ad exists, the form is pre-filled with the ad's data. 
 * Upon submission, the data is validated, and if there are errors, the user 
 * is notified. If everything is valid, the JSON file is updated, and the 
 * user is redirected to the updated ad page.
 */
    require "functions.php";
    require "header.php";
    // If not logged in, show an error message and redirect to login page
    if(!isset($_SESSION["username"])){
        $message = urlencode("1");
        header("Location: login.php?error=$message");
        exit();
    }
    // Load all ads from the JSON file
    // Flag to track if the ad is found
    $ads = loadAds();
    $found = false;
    $data = [];
    $errors = [];
    // If the form is submitted
    if(isset($_POST["submit"])) {
        $ad_id = $_POST["ad_id"];
        if(isset($_GET["id"])){
            $my_id = $_GET["id"];
        }else {
            $my_id = null;
        }
        // Store form data in the $data array
        $data = [
            "id" => $ad_id,
            "lokalita" => $_POST["lokalita"],
            "cena" => $_POST["cena"],
            "mena" => $_POST["mena"],
            "rozmery" => $_POST["rozmery"],
            "popis" => trim($_POST["popis"]),
            "prodej" => $_POST["prodej"],
            // "user_id" => $_POST["user_id"]
        ];
        // Validate all form fields
         $validate_all = validate_all($data);
         $is_price_size_right_format = price_size_check($_POST["cena"],$_POST["rozmery"]);
    
        $errors = [];

        // Search for errors
        if (isset($validate_all) && !validate_all($data)) {
            $errors[] = "Všechna pole musí být vyplněna.";
        }
        if (isset($is_price_size_right_format) && !price_size_check($_POST["cena"], $_POST["rozmery"])) {
            $errors[] = "Cena a rozměry musí být čísla větší než 0.";
        }
        // If no errors, proceed to update the ad
        if(empty($errors)) {
            $found = false;
            // Loop through all ads to find the one with the matching ID
            foreach ($ads as &$ad) {
                if ($ad["id"] == $my_id) {
                    $ad["lokalita"] = trim($_POST["lokalita"]);
                    $ad["cena"] = $_POST["cena"];
                    $ad["mena"] = $_POST["mena"];
                    $ad["rozmery"] = $_POST["rozmery"];
                    $ad["popis"] = trim($_POST["popis"]);
                    $ad["prodej"] = $_POST["prodej"];
                    $found = true;
                    saveAd($ads);
                    // Redirect to the updated ad page
                    $redirect = $ad["id"];
                    header("Location: inzerat.php?id=$redirect");
                    exit();           
            }
        }if (!$found) {
            // If ad is not found, redirect to index page
            header("Location: index.php");
            exit();
        }
    }
}
if (isset($_GET["id"])) {
    $my_id = $_GET["id"];
    $found = false;
    foreach ($ads as &$ad) {
        //validate user id
        if($my_id == $ad["id"]){
            $lokalita = $ad["lokalita"];
            $cena = $ad["cena"];
            $mena = $ad["mena"];
            $rozmery = $ad["rozmery"];
            $popis = $ad["popis"];
            $prodej = $ad["prodej"];
            $found = true;
            $user_id = $ad["user_id"];
        }}
        if(isset($found) && !$found) {
            header("Location: index.php");
            exit();
        }elseif ($user_id != $current_user["id"]) {
            header("Location: index.php");
            exit();
        }
        } else {
            header("Location: index.php");
            exit();
        }
            

    ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addform.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <title>Upravit příspěvek</title>
</head>
<body>
<?php require "nav.php" ?>
<h2 >Upravení inzerátu</h2>
<?php 
    if(isset($errors)){
        foreach($errors as $error){
            $error = htmlspecialchars($error);
            echo "<p class='php'>$error</p>";
        }
}
    ?>
    <div class="form-1">
        <form action="#" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form">
                    <!-- <input type="hidden" name ="user_id" value ="12" > -->
                    <input type="hidden" name="ad_id" value=<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>
                    required
                    >
                    <label for="lokalita">Lokalita</label>
                    <input autocomplete = "off" type="text" name="lokalita" id="lokalita"
                    <?php
                        if(isset($_POST["lokalita"] )){
                            echo "value='" .htmlspecialchars($_POST["lokalita"])."'";
                        }elseif(isset($lokalita)) {
                            echo "value='" .htmlspecialchars($lokalita)."'";
                        }
                    ?>required>
                </div>
                <div class="form">
                    <div class="form" id="select">
                        <label for="cena">Cena</label>
                        <input autocomplete = "off" type="text" name="cena" id="cena"
                        <?php
                        if(isset($_POST["cena"])){
                            echo "value='" .htmlspecialchars($_POST["cena"])."'";
                        }elseif(isset($cena)) {
                            echo "value='" .htmlspecialchars($cena)."'";
                        }
                        ?>
                        required>
                        <select name="mena" id="cena-input">
                        <option value="czk" <?php echo (isset($_POST["mena"]) && $_POST["mena"] === "czk"|| isset($mena) && $mena == "czk")  ? "selected" : ""; ?>>czk</option>
                        <option value="eur" <?php echo (isset($_POST["mena"]) && $_POST["mena"] === "eur"|| isset($mena) && $mena == "eur") ? "selected" : ""; ?>>eur</option>
                        </select>
                    </div>
                <div class="form">
                    <label for="rozmery">Rozměry(m2)</label>
                    <input autocomplete = "off" type="text" name="rozmery" id="rozmery" 
                    <?php
                    if(isset($_POST["rozmery"])){
                        echo "value='" .htmlspecialchars($_POST["rozmery"])."'";
                    }elseif(isset($rozmery)) {
                        echo "value='" .htmlspecialchars($rozmery)."'";
                    }
                    ?> 
                    required>
                </div>
                <div class="form">
                    <label for="popis" class="fieldset">Popis</label>
                    <textarea name="popis" id="popis" cols="94" rows="15" required><?php
                    if(isset($_POST["popis"])){
                        echo htmlspecialchars($_POST["popis"]);
                    }elseif(isset($popis)) {
                        echo htmlspecialchars($popis);
                    }
                    ?></textarea>
                </div>
                <div class="form">
                     <label for="prodej">Chci</label>       
                     <select name="prodej" id="prodej" class="prodej">
                <option value="pronajímat" <?php echo ((isset($_POST["prodej"]) && $_POST["prodej"] === "pronajimat")||( isset($prodej) && $prodej == "pronajímat")) ? "selected" : ""; ?>>pronajímat</option>
                <option value="prodat" <?php echo (isset($_POST["prodej"]) && $_POST["prodej"] === "prodat" || isset($prodej) && $prodej == "prodat") ? "selected" : ""; ?>>prodat</option>
            </select>

                </div>
                <div class="form">
                    <input type="submit" value="Upravit" class="submit" name="submit">
                </div>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>