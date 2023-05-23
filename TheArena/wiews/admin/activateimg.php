<?php

if (isset($_GET['img'])) {
    // Récupérer le chemin de l'image à Supprimer
    $removepath = $_SESSION['previous-img'];
    $sourcePath = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\';     // Destination directory
    if (rename($removePath, $sourcePath)) {
        echo "Image moved successfully.";
    } else {
        echo "Failed to move the image.";
    }

    $imageToPut = $_GET['src'];

    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\captcha\\active';     // Destination directory

    // Construct the new file path in the destination directory
    $newFilePath = $destinationPath . 'captcha.jpg';

    // Move the file to the destination directory
    if (rename($imageToPut, $newFilePath)) {
        echo "Image moved successfully.";
    } else {
        echo "Failed to move the image.";
    }
}
