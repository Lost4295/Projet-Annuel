<?php
session_start();
if (isset($_GET['src'])) {
    // Récupérer le chemin de l'image à Supprimer
    $dirname=$_SERVER['DOCUMENT_ROOT'].'\uploads\\captcha\\';
    $defaultDirname=$_SERVER['DOCUMENT_ROOT'].'\img\\';

    $imagePathid = $_GET['src'];
    $images = glob($dirname."*.{jpg,gif,png}", GLOB_BRACE);
    $defImages = glob($defaultDirname."*.{jpg,gif,png}", GLOB_BRACE);

    $imagePath = $images[$imagePathid];

    if ($_SESSION['chosen_img']== $imagePath){
     $_SESSION['message']="Avertissement : l'image effacée était celle utilisée pour le captcha. Une image au hasard à été choisie. S'il n'y en a pas, retour à l'image par défaut.<br>";
     if (count($images)==1){
          $_SESSION['chosen_img']=$defImages[array_rand($defImages)];
     } else {
          do {$_SESSION['chosen_img']=$images[array_rand($images)];}
          while ($_SESSION['chosen_img']== $imagePath);
     }
    }



    // Supprimer l'image
    if (unlink($imagePath)) {
          $_SESSION["message_type"]='success'; 
            $_SESSION["message"].= " L'image a été supprimée avec succès.";
    } else {
    $_SESSION["message_type"]='danger'; 
         $_SESSION["message"].=  "Une erreur s'est produite lors de la suppression de l'image.";
    }
}
header('Location: /admin_settings');