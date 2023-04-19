<?php
session_start();
require('functions.php');
if (
    count($_POST)!=3
    ||empty($_POST["name"])
    ||empty($_POST["price"])
    ||empty($_POST["date"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name=$_POST["name"];
$price=$_POST["price"];
$date=$_POST["date"];
$description=$_POST["description"];
$errorname="";
$errorprice="";
$errordate="";
$errordescription="";


if (condition($price)) {
    $errorprice="";
}
if (condition($price)) {
    $errorprice="";
}

if (condition($description)) {
    $errordescription="";
}


$dateExploded=explode("-", $date);
if (!checkdate($dateExploded[1], $dateExploded[2], $dateExploded[0])) {
$errordate= "Format de date incorrect";
} else {
    $todaySeconds= time();
    $dateSeconds = strtotime($date);
    $timeSeconds= $todaySeconds - $dateSeconds;
    $time = $timeSeconds/60/60/24/365.25;
    if (($time <= 0.)) {
        $errordate = "La date est dans le passé. Impossible de faire un tournoi dans le passé !";
    }
    if (($time >= 3)) {
        $errordate = "La date est trop lointaine. Essayez de mettre une date inférieure à";
         // mettre date actuelle + 3 ans quoi
    }
}


if (!empty($errorname)||!empty($errorprice)||!empty($errordate)) {
    $error=false;
} else {
    $error=true;
}


if (!$error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errorprice']= $errorprice;
    $_SESSION['errordate']= $errordate;
    header("");
} else {
    $_SESSION['name']= $name;
    $_SESSION['price']= $price;
    $_SESSION['date']= $date;
    header("");
}
