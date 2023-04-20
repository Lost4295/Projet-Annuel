<?php
session_start();
require('../../core/functions.php');
if (
    count($_POST)!=6
    ||!isset($_POST["type"])
    ||empty($_POST["infos"])
    ||!isset($_POST["valueprice"])
    ||empty($_POST["price"])
    ||empty($_POST["eventname"])
    ||empty($_POST["game"])
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
$game=$_POST["game"];
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

if (!is_numeric($valueprice)||$valueprice<=0) {
    $errorvalueprice="Ce prix n'est pas valide.";
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
    header("Location: createeventform.php");
} else {
    $_SESSION['eventname']= $eventname;
    $_SESSION['infos']= $infos;
    $_SESSION['valueprice']= $valueprice;
    $_SESSION['price']= $price;
    $_SESSION['game']= $game;
    die("ok");
    header("");
}
