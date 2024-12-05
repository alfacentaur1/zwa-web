<?php
require "functions.php";
$ads = loadAds();
if(isset($_GET["id"])){
    $rest = [];
    $ad_id = $_GET["id"];
    foreach($ads as $ad){
        if($ad["id"] != $ad_id){
            $rest[] = $ad;
        }
    }
    saveAd($rest);
    $image_id = $_GET["id"]; 
    $image_path = './images/' . $image_id . '.jpg'; // Cesta k souboru

// Zkontrolujte, zda soubor existuje, a pokud ano, smažte ho
if (file_exists($image_path)) {
    unlink($image_path);
} 
    header("Location: index.php?php=uspesne smazano");
}else{
    header("Location: index.php?php=id nenalezeno");
}
?>