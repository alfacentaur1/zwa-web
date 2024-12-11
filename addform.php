<?php
require "functions.php";

$errors = []; // Pole pro ukládání chyb

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
    // Validace polí
    if (isset($validate_all) && !$validate_all) {
        $errors[] = "Všechna pole musí být vyplněna.";
    }

    // Validace ceny a rozměrů
    if (!price_size_check($_POST["cena"], $_POST["rozmery"])) {
        $errors[] = "Cena a rozměry musí být čísla větší než 0.";
    }

    // Validace obrázku
    if (!isset($_FILES['img']) || $_FILES['img']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Musíte nahrát obrázek.";
    } elseif (!is_right_format($_FILES['img'])) {
        $errors[] = "Obrázek musí být ve formátu JPEG nebo PNG.";
    }

    // Pokud nejsou chyby, pokračujeme
    if (empty($errors)) {
        $new_width = 300;
        $new_height = 200;
        $uploadFilePath = "./images/" . $ad_id . ".jpg"; // Uložení jako JPG
    
        // Zpracování obrázku
        $uploaded_img = $_FILES['img']['tmp_name'];
        list($width, $height, $type) = getimagesize($uploaded_img);
    
        switch ($type) {
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($uploaded_img);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($uploaded_img);
                break;
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($uploaded_img);
                break;
            default:
                $errors[] = "Neplatný formát obrázku.";
                break;
        }
    
        // Pokud je formát platný, změňte velikost
        if (empty($errors)) {
            $newImage = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
            // Uložení nového obrázku
            imagejpeg($newImage, $uploadFilePath, 90);
    
            // Uvolnění paměti
            imagedestroy($srcImage);
            imagedestroy($newImage);
    
            // Pokračování s uložením inzerátu
            addAd($data); // Uložení inzerátu
            header("Location: index.php?php=uspesne pridano");
            exit();
        }
    }
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
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form">
                    <input type="hidden" name ="user_id" value ="12" >
                    <input type="hidden" name="ad_id" value=<?php echo strval(uniqid())?>>
                    <label for="lokalita">Lokalita</label>
                    <input type="text" name="lokalita" id="lokalita"
                    <?php
                        if(isset($_POST["lokalita"])){
                            echo "value='" .htmlspecialchars($_POST["lokalita"])."'";
                        }
                    ?>>
                </div>
                <div class="form">
                    <div class="form" id="select">
                        <label for="cena">Cena</label>
                        <input type="text" name="cena" id="cena"
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
                    <input type="text" name="rozmery" id="rozmery" 
                    <?php
                    if(isset($_POST["rozmery"])){
                        echo "value='" .htmlspecialchars($_POST["rozmery"])."'";
                    }
                    ?> 
                    >
                </div>
                <div class="form">
                    <label for="popis" class="fieldset">Popis</label>
                    <textarea name="popis" id="popis" cols="94" rows="15">
                    <?php
                    if(isset($_POST["popis"])){
                        echo htmlspecialchars($_POST["popis"]);
                    }
                    ?>                     
                    </textarea>
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