<?php
/**
 * Job: Add advertisements into json database.

 * The user must be logged in; otherwise, they are redirected to the login 
 * page. The user submits data, which is validated. If anything is wrong, 
 * the user is alerted, and the form is returned with the previously entered
 *  data using the POST superglobal variable. If everything is valid, the 
 * data is saved to inzeraty.json. Each advertisement has a unique ID, and 
 * the user's ID (who added the ad) is stored via a hidden form field. The 
 * image is saved after being reformatted to prevent unnecessary loading 
 * times. Finally, the user is redirected to index.php.

 */
// If user is not logged in, redirect him
    require "header.php";
    if(!isset($_SESSION["username"])){
        $message = urlencode("Je nutné přihlášení.");
        header("Location: login.php?error=$message");
        exit;
    }


    $errors = []; // array for saving errors
    //if form is submitted, create data array
    if (isset($_POST["submit"])) {
        $ad_id = $_POST["ad_id"];
        $data = [
            "id" => $ad_id,
            "lokalita" => $_POST["lokalita"],
            "cena" => $_POST["cena"],
            "mena" => $_POST["mena"],
            "rozmery" => $_POST["rozmery"],
            "popis" => trim($_POST["popis"]),
            "prodej" => $_POST["prodej"],
            "img" => $_FILES["img"],
            "user_id" => $_POST["user_id"]
            
        ];
        $validate_all = validate_all($data);
        $is_price_size_right_format = price_size_check($_POST["cena"],$_POST["rozmery"]);
        // array validation
        if (isset($validate_all) && !$validate_all) {
            $errors[] = "Všechna pole musí být vyplněna.";
        }

        // size and price validation
        if (!price_size_check($_POST["cena"], $_POST["rozmery"])) {
            $errors[] = "Cena a rozměry musí být čísla větší než 0.";
        }

        // Validate image format
if (!isset($_FILES['img']) || $_FILES['img']['error'] !== UPLOAD_ERR_OK) {
    // If image is not uploaded or there is an error, add error message
    $errors[] = "Musíte nahrát obrázek."; // You must upload an image.
} elseif (!is_right_format($_FILES['img'])) {
    // If the image is not in JPEG or PNG format, add error message
    $errors[] = "Obrázek musí být ve formátu JPEG nebo PNG."; // The image must be in JPEG or PNG format.
}

// Proceed if there are no errors
if (empty($errors)) {
    $new_width = 300; // Desired width for the resized image
    $new_height = 200; // Desired height for the resized image
    $uploadFilePath = "./images/" . $ad_id . ".jpg"; // Save image as JPG with ad ID as filename
    
    // Get the temporary image file and its dimensions
    $uploaded_img = $_FILES['img']['tmp_name'];
    list($width, $height, $type) = getimagesize($uploaded_img); // Get original image dimensions and type
    
    // Process image based on its type (JPEG or PNG)
    switch ($type) {
        case IMAGETYPE_JPEG:

            $srcImage = imagecreatefromjpeg($uploaded_img);
            break;
        case IMAGETYPE_PNG:

            $srcImage = imagecreatefrompng($uploaded_img);
            break;
        default:
            // If the image format is invalid, add error message
            $errors[] = "Neplatný formát obrázku."; // Invalid image format.
            break;
    }

    // If no errors and the image format is valid, resize the image
    if (empty($errors)) {
        // Create a new true-color image with desired dimensions
        $newImage = imagecreatetruecolor($new_width, $new_height);
        
        // Copy and resize the uploaded image into the new image resource
        imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        // Save the resized image as JPEG
        imagejpeg($newImage, $uploadFilePath, 90); // Save with 90% quality
        
        // Free up memory by destroying the image resources
        imagedestroy($srcImage);
        imagedestroy($newImage);
        
        addAd($data); // Save the advertisement data
        
        // Redirect to the ad page
        header("Location: inzerat.php?id=$ad_id");
        exit();
    }
} }
        
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
    <title>Přidat příspěvek</title>
</head>
<body>
<?php require "nav.php" ?>
    <h2 >Přidání inzerátu</h2>
    <?php 
    foreach($errors as $error){
        echo "<p class='php'>$error</p>";
    }
    
    ?>
    <div class="form-1">
        <form action="addform.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form">
                    <input type="hidden" name ="user_id" value =<?php 
                    if(isset($current_user)){
                        echo $current_user["id"];
                    }
                    
                    ?>>
                    <input type="hidden" name="ad_id" value=<?php echo strval(uniqid())?>>
                    <label for="lokalita">Lokalita</label>
                    <input autocomplete = "off" type="text" name="lokalita" id="lokalita"
                    <?php
                        if(isset($_POST["lokalita"])){
                            echo "value='" .htmlspecialchars($_POST["lokalita"])."'";
                        }
                    ?>>
                </div>
                <div class="form">
                    <div class="form" id="select">
                        <label for="cena">Cena</label>
                        <input autocomplete = "off" type="text" name="cena" id="cena"
                        <?php
                        if(isset($_POST["cena"])){
                            echo "value='" .htmlspecialchars($_POST["cena"])."'";
                        }
                        ?>
                        >
                        <select name="mena" id="cena-input">
                        <option value="czk" <?php echo (isset($_POST['mena']) && $_POST['mena'] === 'czk') ? 'selected' : ''; ?>>czk</option>
                        <option value="eur" <?php echo (isset($_POST['mena']) && $_POST['mena'] === 'eur') ? 'selected' : ''; ?>>eur</option>
                        </select>
                    </div>
                <div class="form">
                    <label for="rozmery">Rozměry(m2)</label>
                    <input autocomplete = "off" type="text" name="rozmery" id="rozmery" 
                    <?php
                    if(isset($_POST["rozmery"])){
                        echo "value='" .htmlspecialchars($_POST["rozmery"])."'";
                    }
                    ?> 
                    >
                </div>
                <div class="form">
                    <label for="popis" class="fieldset">Popis</label>
                    <textarea name="popis" id="popis" cols="94" rows="15"><?php if(isset($_POST["popis"])){
                        echo htmlspecialchars($_POST["popis"]);
                    }else{
                        echo "";    
                    }
                    ?></textarea>
                <div class="form" id="img">
                    <label for="img-input">Foto</label>
                    <input type="file" name="img" id="img-input" accept="image/*">
                </div>
                </div>
                <div class="form">
                    <label for="prodej">Chci</label>       
                    <select name="prodej" id="prodej" class="prodej">
                <option value="pronajímat" <?php echo (isset($_POST["prodej"]) && ($_POST["prodej"] === "pronajímat" || $_POST["prodej"] === "pronajimat")) ? "selected" : ""; ?>>pronajímat</option>
                <option value="prodat" <?php echo (isset($_POST["prodej"]) && $_POST["prodej"] === "prodat") ? "selected" : ""; ?>>prodat</option>
            </select>
                </div>
                <div class="form">
                    <input type="submit" value="Přidat" class="submit" name="submit">
                </div>
                </div>
            </fieldset>
        </form>
    </div>
</body>
</html>