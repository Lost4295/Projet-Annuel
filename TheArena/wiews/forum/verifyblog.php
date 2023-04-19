<?php
session_start();
require('functions.php');
if (
    count($_POST)!=2
    ||empty($_POST["blogname"])
    ||empty($_POST["blogdesc"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$blogname= trim($_POST["blogname"]);
$blogdesc= trim($_POST["blogdesc"]);
$errorname="";
$errordesc="";

if (strlen($blogname)<3) {
    $errorname= "Le nom doit faire plus de 2 caractères.";
}

if (!empty($blogdesc)) {
    if (strlen($blogdesc)<3) {
        $errordesc= "La description doit faire plus de 2 caractères.";
    } else {
        if (strlen($blogdesc)>500) {
            $errordesc= "La description doit faire moins de 500 caractères.";
        }
    }
} else {
    $errordesc= "La description ne peut pas être vide.";
}


if (!empty($errorname)||!empty($errordesc)) {
    $error=false;
} else {
    $error=true;
}


if (!$error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errordesc']= $errordesc;
    header("Location: ");
} else {
    $_SESSION['blogname']= $blogname;
    $_SESSION['blogdesc']= $blogdesc;
    header("Location: ");
}
