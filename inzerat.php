<?php
    require "functions.php";
    $ads = loadAds();

?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inzerat.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <title>Inzerát</title>
</head>
<body>
<?php require "nav.php" ?>

    <?php
    if(isset($_GET["id"])){
        $current_id = $_GET["id"];

        // Prohledávání inzerátů
        if(isset($current_id)){
            $foundAd = false;
            foreach ($ads as $ad) {
                if (isset($ad["id"]) && $ad["id"] == $current_id) {
                    $foundAd = $ad;
                    break;
                }

            }
            if ($foundAd != false) {
                $prodej = htmlspecialchars($foundAd["prodej"]);
                $lokalita = htmlspecialchars($foundAd["lokalita"]);
                $cena = htmlspecialchars($foundAd["cena"]);
                $mena = htmlspecialchars($foundAd["mena"]);
                $rozmery = htmlspecialchars($foundAd["rozmery"]);
                $popis = htmlspecialchars($foundAd["popis"]);

                echo "
    <div class='content-container'>
    <div class='inzerat'>
            <img src='' alt='obrazek-inzeratu'>
            <div class='text-container'>

            </div>
            <div class='text-container'>
                <p class='underline'>Lokalita</p>
                <p>$lokalita</p>
            </div>
            <div class='text-container'>
                <p class='underline'>Cena</p>
                <p>$cena $mena/měsíc</p>
            </div>
            <div class='text-container'>
                <p class='underline'>Rozměry</p>
                <p>$rozmery m2</p>
            </div>
            <div class='text-container'>
                <p class='underline'>Popis</p>
                <p>$popis</p>
            </div>
            <div class='text-container'>
                <p class='underline'>Uživatel</p>
                <p>Filip K</p>
            </div>
            <div class='text-container'>
                <p class='underline'>Email</p>
                <p>kopecfi3@student.cvut.cz</p>
            </div>
            <div class='prispevek-uprava'>
                <a href='upravit.php?id=$current_id' class='prispevek-a'>upravit</a>
                <a href='' class='prispevek-a'>smazat</a>
            </div>
        </div>
    </div>
    ";
    
            } elseif($foundAd == false) {
                echo "<h1>inzerat s danym id nebyl nalezen</h1>";
            }
            
        }
    }else {
        echo "<h1>inzerat s danym id nebyl nalezen</h1>";
    }
    
?>



        
</body>
</html>
