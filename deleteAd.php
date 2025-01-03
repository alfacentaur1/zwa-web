<?php
/**
 * Job: Delete ad.
 * 
 * When the "Delete" button is clicked for a specific advertisement, its ID * is retrieved using the GET superglobal variable. The script then iterates * through all advertisements in the inzeraty.json file. If an  
 * advertisement's ID does not match the one retrieved from the GET 
 * variable, it is added to an array of remaining advertisements. This array 
 * then replaces the contents of the JSON file, effectively removing the 
 * advertisement with the specified ID. Finally, the user is redirected to 
 * index.php.
 */
session_start();
if(!isset($_SESSION["username"])){
    $message = urlencode("2");
    header("Location: login.php?error=$message");
    exit();
}
require_once "functions.php";
$users = loadUsers();
$current_user = null;

//load ads, then loop through, if id does not match add it to rest
//replace inzeraty.json with rest
$ads = loadAds();
if(isset($_GET["id"])){
    if(isset($_SESSION["username"])){
        $current_user = getUser($_SESSION["username"]);
        $user_id = $current_user["id"];
        $ads = loadAds();
        foreach($ads as $ad){
            if($ad["id"] == $_GET["id"] && $current_user["role"] != "admin"){
                if($user_id != $ad["user_id"]){
                    header("Location: index.php");
                    exit();
                }
            }
        }
    
    }
    $rest = [];
    $ad_id = $_GET["id"];
    foreach($ads as $ad){
        if($ad["id"] != $ad_id){
            $rest[] = $ad;
        }
    }
    saveAd($rest);
    $image_id = $_GET["id"]; 
    $image_path = './images/' . $image_id . '.jpg'; // path to file

// check if image exists, if yes, delete
if (file_exists($image_path)) {
    unlink($image_path);
} 
    header("Location: index.php");
    exit();
}else{
    header("Location: index.php?php=id nenalezeno");
    exit();
}
?>