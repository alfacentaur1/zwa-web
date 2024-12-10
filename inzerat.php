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
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <title>Inzerát</title>
</head>
<body>
<?php require "nav.php"; ?>

<?php
if (isset($_GET["id"])) {
    $current_id = $_GET["id"];

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
        ?>

        <div class="content-container">
            <div class="inzerat">
                <img src="images/<?php echo $current_id; ?>" alt="obrazek-inzeratu">
                
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
                    <p>Filip K</p>
                </div>

                <div class="text-container">
                    <p class="underline">Email</p>
                    <p>kopecfi3@student.cvut.cz</p>
                </div>

                <div class="prispevek-uprava">
                    <a href="upravit.php?id=<?php echo $current_id; ?>" class="prispevek-a">upravit</a>
                    <a href="deleteAd.php?id=<?php echo $current_id; ?>" class="prispevek-a">smazat</a>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo "<h1>Inzerát s daným ID nebyl nalezen</h1>";
    }
} else {
    echo "<h1>Inzerát s daným ID nebyl nalezen</h1>";
}
?>

</body>
</html>
