<?php
require "header.php";
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inzerat.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <title>Inzerát</title>
</head>
<body>
<?php require "nav.php"; ?>

<?php
if (isset($_GET["id"])) {
    $current_id = $_GET["id"]; // id of ad
    $ad_user = null;
    $ads = loadAds();

    // Searching ads
    $foundAd = false;
    foreach ($ads as $ad) {
        if (isset($ad["id"]) && $ad["id"] == $current_id) {
            $foundAd = $ad;
            break;
        }
    }


    if ($foundAd) {
        $prodej = htmlspecialchars($foundAd["prodej"]);
        $lokalita = htmlspecialchars($foundAd["lokalita"]);
        $cena = htmlspecialchars($foundAd["cena"]);
        $mena = htmlspecialchars($foundAd["mena"]);
        $rozmery = htmlspecialchars($foundAd["rozmery"]);
        $popis = htmlspecialchars($foundAd["popis"]);

    // get the ad user
    foreach($users as $user) {
        if($user["id"] == $foundAd["user_id"]){
            $ad_user = $user;
            break;
        }
    }
        ?>

        <div class="content-container">
            <div class="inzerat">
                <img src="<?php echo 'images/'.$current_id; ?>" alt="obrazek-inzeratu">
                
                <div class="text-container">
                    <p class="underline">Lokalita</p>
                    <p><?php echo $lokalita; ?></p>
                </div>

                <div class="text-container">
                    <p class="underline">Cena</p>
                    <p>
                        <?php
                        echo $cena . " " . $mena;
                        if ($prodej == "pronajimat" || $prodej == "pronajímat") {
                            echo " /měsíc";
                        }
                        ?>
                    </p>
                </div>

                <div class="text-container">
                    <p class="underline">Rozměry</p>
                    <p><?php echo $rozmery; ?> m2</p>
                </div>

                <div class="text-container">
                    <p class="underline">Popis</p>
                    <p><?php echo $popis; ?></p>
                </div>

                <div class="text-container">
                    <p class="underline">Uživatel</p>
                    <p>
                    <?php
                     if(isset($ad_user)){
                        echo htmlspecialchars($ad_user["username"]);
                     }
                     ?>

                    </p>
                </div>

                <div class="text-container">
                    <p class="underline">Email</p>
                    <p><?php
                     if(isset($ad_user["email"])){
                        echo htmlspecialchars($ad_user["email"]);
                     }
                     ?></p>
                </div>
                <?php
                if(isset($current_user) && isset($ad_user)&& (($current_user["id"] == $ad_user["id"]))){?>
                <div class="prispevek-uprava">
                    <a href="<?php echo 'upravit.php?id='.$current_id; ?>" class="prispevek-a">upravit</a>
                    <a href="<?php echo 'deleteAd.php?id='.$current_id; ?>" class="prispevek-a">smazat</a>
                
                </div>
                <?php
                }elseif(isset($current_user)&&($current_user["role"]) == "admin"){
                ?>
                <div class="prispevek-uprava">
                    <a href="deleteAd.php?id=<?php echo $current_id; ?>" class="prispevek-a">smazat</a>
                </div>
                <?php }?>
            </div>
        </div>

        <?php
    } else {
        echo "Inzerát s daným ID nebyl nalezen";
    }
} else {
    echo "Inzerát s daným ID nebyl nalezen";
}
?>

</body>
</html>
