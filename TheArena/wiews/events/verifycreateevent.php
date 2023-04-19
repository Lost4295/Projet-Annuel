<?php
session_start();
require('../../core/functions.php');
if (
    count($_POST)!=5
    ||!isset($_POST["type"])
    ||empty($_POST["infos"])
    ||empty($_POST["valueprice"])
    ||empty($_POST["price"])
    ||empty($_POST["eventname"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$type=$_POST["type"];
$infos=$_POST["infos"];
$valueprice=strtolower(trim($_POST["valueprice"]));
$price=$_POST["price"];
$eventname=$_POST["eventname"];
$errortype="";
$errorinfos="";
$errorvalueprice="";
$errorprice="";
$erroreventname="";

$types=[0,1];

if (!in_array($type, $types)) {
    $errortype="Ce type n'existe pas.";
}

if (strlen($infos)<3) {
    $errorinfos="Ce nom d'utilisateur est trop court.";
}
if (strlen($infos)>30) {
    $errorinfos="Ce nom d'utilisateur est trop long.";
}


if (!empty($erroreventname)||!empty($errorinfos)||!empty($errorprice)||!empty($errortype)||!empty($errorvalueprice)) {
    $error=false;
} else {
    $error=true;
}


if (!$error) {
    $_SESSION['erroreventname']= $erroreventname;
    $_SESSION['errorinfos']= $errorinfos;
    $_SESSION['errorvalueprice']= $errorvalueprice;
    $_SESSION['errorprice']= $errorprice;
    $_SESSION['errortype']= $errortype;
    header("");
} else {
    $_SESSION['eventname']= $eventname;
    $_SESSION['infos']= $infos;
    $_SESSION['valueprice']= $valueprice;
    $_SESSION['price']= $price;
    header("");
}
