<?php
session_start();
if (isset($_GET['src'])) {
    // Récupérer le chemin de l'image à Supprimer
    $dirname=$_SERVER['DOCUMENT_ROOT'].'\uploads\\captcha\\';

    $imagePathid = $_GET['src'];
    $images = glob($dirname."*.{jpg,gif,png}", GLOB_BRACE);

    $imagePath = $images[$imagePathid];



    // Supprimer l'image
    if (unlink($imagePath)) {
    $_SESSION["message_type"]='success'; 
         $_SESSION["message"]=  "L'image a été supprimée avec succès.";
    } else {
    $_SESSION["message_type"]='danger'; 
         $_SESSION["message"]=  "Une erreur s'est produite lors de la suppression de l'image.";
    }
}
header('Location: /admin/settings');