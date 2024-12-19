<?php
/**
 * Job: Display ad details.
 * 
 * The user can access this page by clicking on an ad on the index.php page.
 *  The ad is displayed based on the ID, which is retrieved from the GET 
 * superglobal variable. The code uses this ID to search for the 
 * corresponding ad object in the JSON file. The details of the ad are then 
 * displayed.
 * If the user is an admin, they have the option to delete the ad. If the 
 * user is the one who posted the ad, they have the option to edit it. If 
 * the user is neither the admin nor the one who posted the ad, no options 
 * forediting or deleting are displayed.
 * This is determined using the SESSION superglobal variable. First, the 
 * user object is retrieved from the users.json file using the "username" 
 * key. From there, we access the role and ID of the user. If the user's ID
 *  matches the ID of the user who posted the ad, the appropriate options 
 * (delete or edit) are displayed. The same logic is applied for the admin 
 * role.
 * If the user clicks on "Delete," they are redirected to deleteAd.php with 
 * the ad's ID in the URL.
 * If the user clicks on "Edit," they are redirected to edit.php with the 
 * ad's ID in the URL.

 */
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
    $current_id = $_GET["id"]; // Store the ad ID from the URL
    $ad_user = null; 
    $ads = loadAds(); // Load all ads from the JSON file

    // Searching for the ad by ID
    $foundAd = false; 
    foreach ($ads as $ad) {
        // Check if the current ad's ID matches the provided ID
        if (isset($ad["id"]) && $ad["id"] == $current_id) {
            $foundAd = $ad; // Store the found ad in the variable
            break; 
        }
    }

    // If the ad was found, process its details
    if ($foundAd) {
        // Sanitize ad fields to prevent XSS
        $prodej = htmlspecialchars($foundAd["prodej"]);
        $lokalita = htmlspecialchars($foundAd["lokalita"]);
        $cena = htmlspecialchars($foundAd["cena"]);
        $mena = htmlspecialchars($foundAd["mena"]);
        $rozmery = htmlspecialchars($foundAd["rozmery"]);
        $popis = htmlspecialchars($foundAd["popis"]);

        // Find the user who posted the ad
        foreach ($users as $user) {
            // Match the user ID with the ad's user ID
            if ($user["id"] == $foundAd["user_id"]) {
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
