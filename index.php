<?php
        require "header.php";
        $ads = loadAds();
        if ($ads){
        // sort "rozmery" - in ascending order
        usort($ads, function ($a, $b) {
            return (int)$a['rozmery'] <=> (int)$b['rozmery'];
        
    });}

    ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavní stránka</title>
    <link rel="stylesheet" href="css/mainpage.css">
    <link rel="stylesheet" href="css/univerzal.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
</head>
<body>
<?php require "nav.php" ?>
<?php 
    // set the limit (ads for page) and actual page
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT, ["options" => ["default" => 4, "min_range" => 1]]);
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1, "max_range" => ceil(getCount($ads)/$limit)]]);
    $offset = ($page - 1) * $limit;
    $ads_limit = listAds($ads,$limit, $offset);
    if (isset($_GET["php"])){
        $message = htmlspecialchars($_GET["php"]);
        echo "<div class='phpdiv'></div><p class='php'>$message</p></div>";
    }
    
    ?>
    <div class="nadpis">
        <h3>Hlavní stránka</h3>
    </div>
    <div class="main">  
    <?php 
    if($ads){
        foreach ($ads_limit as $ad): ?>
            <?php 
                // Access ad details and escape output
                $id = htmlspecialchars($ad["id"]);
                $lokalita = htmlspecialchars($ad["lokalita"]);
                $cena = htmlspecialchars($ad["cena"]);
                $mena = htmlspecialchars($ad["mena"]);
                $rozmery = htmlspecialchars($ad["rozmery"]);
                $prodej = htmlspecialchars($ad["prodej"]);
            ?>
            <div class="prispevek">
                <a href="inzerat.php?id=<?php echo $id; ?>">
                    <div class="prispevek-text">
                        <div class="prodej">
                            <h2><?php echo $prodej; ?></h2>
                        </div>
                        <div class="prispevek-img">
                            <img src="images/<?php echo $id; ?>" alt="obrazek-inzeratu">
                        </div>
                        <div class="prispevek-lokalita">
                            <p>Lokalita: <?php echo $lokalita; ?></p>
                        </div>
                        <div class="prispevek-cena">
                            <p>Cena: <?php echo $cena . ' ' . $mena;
                            if ($prodej == "pronajimat" || $prodej == "pronajímat") {
                                echo " /měsíc";
                            } 
                            ?></p>
                        </div>
                        <div class="prispevek-rozmery">
                            <p>Rozměry: <?php echo $rozmery; ?> m<sup>2</sup></p>
                        </div>
                    </div>
                </a>  
            </div>
        <?php endforeach; ?>
        <?php 
        // Pagination links
        $totalAds = count($ads); 
        $totalPages = ceil($totalAds / $limit);
        echo '<div class="buttons">';
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) { // if we are on this page, its not clickable
                echo '<span>' . $i . '</span>';
            } else {// continue
                echo '<a  href="?limit=' . $limit . '&page=' . $i . '">' . $i . '</a> ';
            }
        }
        echo '</div>';
    } else {
        echo '<div class="empty">Zadny inzerat nenalezen.</div>';
        }
    ?>
</div>
</body>
</html>