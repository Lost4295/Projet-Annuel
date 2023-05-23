<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST)!=4
    ||!isset($_POST["type"])
    ||empty($_POST["infos"])
    ||empty($_POST["eventname"])
    ||empty($_POST["game"])
    ||!isset($_FILES['image'])
) { print_r($_POST); print_r($_FILES);
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
    $dirname=$_SERVER['DOCUMENT_ROOT'].'\uploads\\events\\';
        $tmpName = $_FILES['image']['tmp_name'];
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $encodedimg=encodeImage($tmpName, $type);
        move_uploaded_file($tmpName, $dirname.$name);
    $_SESSION['eventname']= $eventname;
    $_SESSION['infos']= $infos;
    $_SESSION['game']= $game;
    $_SESSION['type']= $type;
    $connection=connectToDB();
    $queryPrepared=$connection->prepare("SELECT id FROM ".PREFIX."users WHERE email=:email");
    $queryPrepared->execute([
        'email'=>$_SESSION['email']
    ]);
    $result=$queryPrepared->fetch(PDO::FETCH_ASSOC);
    $manager_id=$result['id'];
    $queryPrepared=$connection->prepare("INSERT INTO ".PREFIX."events (name, description, type, game, manager_id, image) VALUES (:eventname,:infos,:type,:game, :manager_id, :image)");
    $queryPrepared->execute([
        'eventname'=>$eventname,
        'infos'=>$infos,
        'type'=>$type,
        'game'=>$game,
        'manager_id'=>$manager_id,
        'image'=>$encodedimg
    ]);
    echo "done !";
    header("Location: /events");
}

