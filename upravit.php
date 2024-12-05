<?php
    require "functions.php";
    //TODO
    // pres session user id
    //
    $ads = loadAds();
    $data = [];
    if(isset($_POST["submit"])) {
        $ad_id = $_POST["ad_id"];
        if(isset($_GET["id"])){
            $my_id = $_GET["id"];
        }else {
            $my_id = null;
        }

        
        $found = false;
            foreach ($ads as &$ad) {
                if ($ad["id"] == $my_id) {
                    $ad["lokalita"] = trim($_POST["lokalita"]);
                    $ad["cena"] = $_POST["cena"];
                    $ad["mena"] = $_POST["mena"];
                    $ad["rozmery"] = $_POST["rozmery"];
                    $ad["popis"] = trim($_POST["popis"]);
                    $ad["prodej"] = $_POST["prodej"];
                    $ad["user_id"] = $_POST["user_id"];
                    $found = true;
                    saveAd($ads);
                    header("Location: index.php?php=uspesne upraveno ");
                    break; 
                    
            }
        
        if (!$found) {
            $errors[] = "Nenalezen inzerát s daným ID.";
        }
    }
 
         $validate_all = validate_all($data);
         $is_price_size_right_format = price_size_check($_POST["cena"],$_POST["rozmery"]);
    
        $errors = [];

        //hledame errory
        if (isset($validate_all) && !validate_all($data)) {
            $errors[] = "Všechna pole musí být vyplněna.";
        }
        if (isset($is_price_size_right_format) && !price_size_check($_POST["cena"], $_POST["rozmery"])) {
            $errors[] = "Cena a rozměry musí být čísla větší než 0.";
        }
        //pridame do db
        if(empty($errors)) {

        //     foreach ($ads as &$ad) {
        //       if ($ad['id'] == $my_id) {
        //         $ad[] = $name;
        //         $ad[] = $age;
        //         break;
        //       }
        //     } 
        //   }

        }
    }

    if (isset($_GET["id"])) {
        $my_id = $_GET["id"];
        $found = false;
        foreach ($ads as &$ad) {
                $lokalita = $ad["lokalita"];
                $cena = $ad["cena"];
                $mena = $ad["mena"];
                $rozmery = $ad["rozmery"];
                $popis = $ad["popis"];
                $prodej = $ad["prodej"];
                $found = true;
            }}
            if(!$found) {
                $errors[] = "nenalazen inzerát s daným id";
            }
         
    ?>



<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addform.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <title>Upravit příspěvek</title>
</head>
<body>
<?php require "nav.php" ?>
    <h2 >Upravení inzerátu</h2>
    <?php 
    if(isset($errors)){
        foreach($errors as $error){
            echo "<p class='php'>$error</p>";
        }
}
    
    
    ?>
    <div class="form-1">
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <div class="form">
                    <input type="hidden" name ="user_id" value ="12" >
                    <input type="hidden" name="ad_id" value=<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>
  
                    >
                    <label for="lokalita">Lokalita</label>
                    <input type="text" name="lokalita" id="lokalita"
                    <?php
                        if(isset($_POST["lokalita"] )){
                            echo "value='" .htmlspecialchars($_POST["lokalita"])."'";
                        }elseif(isset($lokalita)) {
                            echo "value='" .htmlspecialchars($lokalita)."'";
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
                        }elseif(isset($cena)) {
                            echo "value='" .htmlspecialchars($cena)."'";
                        }
                        ?>
                        >
                        <select name="mena" id="cena-input">
                        <option value="czk" <?php echo (isset($_POST["mena"]) && $_POST["mena"] === "czk"|| isset($mena) && $mena == "czk")  ? "selected" : ""; ?>>czk</option>
                        <option value="eur" <?php echo (isset($_POST["mena"]) && $_POST["mena"] === "eur"|| isset($mena) && $mena == "eur") ? "selected" : ""; ?>>eur</option>
                        </select>
                    </div>
                <div class="form">
                    <label for="rozmery">Rozměry(m2)</label>
                    <input type="text" name="rozmery" id="rozmery" 
                    <?php
                    if(isset($_POST["rozmery"])){
                        echo "value='" .htmlspecialchars($_POST["rozmery"])."'";
                    }elseif(isset($rozmery)) {
                        echo "value='" .htmlspecialchars($rozmery)."'";
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
                    }elseif(isset($popis)) {
                        echo htmlspecialchars($popis);
                    }
                    ?>                     
                    </textarea>
                </div>
                <div class="form">
                     <label for="prodej">Chci</label>       
                     <select name="prodej" id="prodej" class="prodej">
                <option value="pronajimat" <?php echo (isset($_POST["prodej"]) && $_POST["prodej"] === "pronajimat"|| isset($prodej) && $prodej == "pronajimat") ? "selected" : ""; ?>>pronajímat</option>
                <option value="prodat" <?php echo (isset($_POST["prodej"]) && $_POST["prodej"] === "prodat" || isset($prodej) && $prodej == "pronajimat") ? "selected" : ""; ?>>prodat</option>
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