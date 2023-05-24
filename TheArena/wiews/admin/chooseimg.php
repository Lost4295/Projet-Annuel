<?php
session_start();
if (isset($_GET['src'])) {
     $dirname=$_SERVER['DOCUMENT_ROOT'].'\uploads\\captcha\\';

    $imagePathid = $_GET['src'];
    $images = glob($dirname."*.{jpg,gif,png}", GLOB_BRACE);

    $imagePath = $images[$imagePathid];

$_SESSION['chosen_img']=$imagePath;
}
if ($_SESSION['chosen_img']) {
    $_SESSION["message_type"]='success'; 
         $_SESSION["message"]=  "L'image a été sélectionée avec succès. nom de l'image : ".$imagePath;
    } else {
    $_SESSION["message_type"]='danger'; 
         $_SESSION["message"]=  "Une erreur s'est produite lors de la sélection de l'image.";
    }
header('Location: /admin/settings');