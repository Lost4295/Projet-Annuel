<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";;
if (
    count($_POST)!=5
    ||!isset($_POST["type"])
    ||empty($_POST["infos"])
    ||empty($_POST["manager_id"])
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
$manager_id=$_POST["manager_id"];
$errortype="";
$errorinfos="";
$errormanagerid="";
$erroreventname="";

$types=[0,1];

if (!in_array($type, $types)) {
    $errortype="Ce type n'existe pas.";
}

if (strlen($infos)<3) {
    $errorinfos="Cette description est trop courte.";
}
$db=connectToDB();
$query=$db->prepare("SELECT id FROM zeya_users where scope=".ORGANIZER."||scope= ".SUPADMIN."|| scope=".ADMIN.";");
$query->execute();
$result= $query->fetch(PDO::FETCH_ASSOC);
if (!array_search($manager_id, $result)) {
    $errormanagerid="L'id est incorrect.";
}
if (!empty($erroreventname)||!empty($errorinfos)||!empty($errortype)||!empty($errormanagerid)){
    $error=true;
} else {
    $error=false;
}




if ($error) {
    $_SESSION['erroreventname']= $erroreventname;
    $_SESSION['errorinfos']= $errorinfos;
    $_SESSION['errortype']= $errortype;
    header("Location:/admin/events/create");
} else {
    $_SESSION['eventname']= $eventname;
    $_SESSION['infos']= $infos;
    $_SESSION['game']= $game;
    $_SESSION['type']= $type;
    
    $queryPrepared=$db->prepare("INSERT INTO ".PREFIX."events (name, description, manager_id, game, type) VALUES (:name,:description, :manager_id, :game, :type)");
    $queryPrepared->execute([
        'name'=>$eventname,
        'description'=>$infos,
        'manager_id'=>$manager_id,
        'type'=>$type,
        "game"=>$game
    ]);
    header("Location: /admin/events"); 
}

