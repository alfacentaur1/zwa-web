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
    header("Location: index.php?php=uspesne smazano");
}else{
    header("Location: index.php?php=id nenalezeno");
}
?>