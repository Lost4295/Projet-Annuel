<?php

if (isset($_GET['src'])) {
    // Récupérer le chemin de l'image à Supprimer

    $imagePath = $_GET['src'];

    $serverImagePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $imagePath;
    // Supprimer l'image
    if (unlink($imagePath)) {
        echo "L'image a été supprimée avec succès.";
    } else {
        echo "Une erreur s'est produite lors de la suppression de l'image.";
    }
} else {
    echo "Le chemin de l'image n'a pas été spécifié.";
}