<?php

if (isset($_GET['img'])) {
    // Récupérer le chemin de l'image à Supprimer
    $removepath = $_SESSION['previous-img'];
    $sourcePath = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\';     // Destination directory
    if (rename($removePath, $sourcePath)) {
        echo "Image removed successfully.";
    } else {
        echo "Failed to remove the image.";
    }

    $imageToPut = $_GET['src'];

    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\active';     // Destination directory

    // Construct the new file path in the destination directory
    $newFilePath = $destinationPath . 'captcha.jpg';

    // Move the file to the destination directory
    if (rename($imageToPut, $newFilePath)) {
        echo "Image to activate moved successfully.";
    } else {
        echo "Failed to move the image to activate.";
    }
}

sleep(5);
header('Location: /admin/settings.php'); 