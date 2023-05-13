<?php
session_start();
require('../../core/functions.php');
if (
    count($_POST)!=4
    ||!isset($_POST["type"])
    ||empty($_POST["infos"])
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
$eventname=$_POST["eventname"];
$game=$_POST["game"];
$errortype="";
$errorinfos="";
$erroreventname="";

$types=[0,1];

if (!in_array($type, $types)) {
    $errortype="Ce type n'existe pas.";
}

if (strlen($infos)<3) {
    $errorinfos="Cette description est trop courte.";
}

if (!empty($erroreventname)||!empty($errorinfos)||!empty($errortype)) {
    $error=false;
} else {
    $error=true;
}

//FIXME: Add the event to the database
if (!$error) {
    $_SESSION['erroreventname']= $erroreventname;
    $_SESSION['errorinfos']= $errorinfos;
    $_SESSION['errortype']= $errortype;
    header("Location:/wiews/events/createeventform.php");
} else {
    $_SESSION['eventname']= $eventname;
    $_SESSION['infos']= $infos;
    $_SESSION['game']= $game;
    $_SESSION['type']= $type;
    $connection=connectToDB();
    $queryPrepared=$connection->prepare("INSERT INTO ".PREFIX."events (name, description) VALUES (:eventname,:infos)");
    $queryPrepared->execute([
        $eventname,
        $infos,
        $price,
        $valueprice,
        $type,
        $game
    ]);
    header(""); 
}
