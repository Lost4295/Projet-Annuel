<?php
session_start();
require('functions.php');
if (
    count($_POST)!=4
    ||empty($_POST["name"])
    ||empty($_POST["price"])
    ||empty($_POST["image"])
    ||!isset($_POST["description"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name=$_POST["name"];
$price=$_POST["price"];
$image=$_POST["image"];
$description=$_POST["description"];
$errorname="";
$errorprice="";
$errorimage="";
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

if (condition($image)) {
    $errorimage="";
}


if (!empty($errorname)||!empty($errorprice)||!empty($errordescription)||!empty($errorimage)) {
    $error=false;
} else {
    $error=true;
}

//FIXME: Add the item to the database
if (!$error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errorprice']= $errorprice;
    $_SESSION['errorimage']= $errorimage;
    $_SESSION['errordescription']= $errordescription;
    header("");
} else {
    $_SESSION['name']= $name;
    $_SESSION['price']= $price;
    $_SESSION['image']= $image;
    $_SESSION['description']= $description;
    header("");
}

