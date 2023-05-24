<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST)!=3
    ||empty($_POST["blogname"])
    ||empty($_POST["author"])
    ||empty($_POST["blogdesc"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}


$blogname= trim($_POST["blogname"]);
$blogdesc= trim($_POST["blogdesc"]);
$author= $_POST["author"];
$errorname="";
$errorauthor="";
$errordesc="";

if (strlen($blogname)<3) {
    $errorname= "Le nom doit faire plus de 2 caractères.";
}
$db = connectToDB();
$query = $db->prepare("SELECT * FROM ".PREFIX."forums where name =:name");
$query->execute(['name'=>$blogname]);
$result = $query->fetch();

if ($result){
    $errorname = "Ce blog existe déjà.";
}

$query = $db->prepare("SELECT * FROM ".PREFIX."forums where author =:author");
$query->execute(['author'=>$author]);
$result = $query->fetch();

if (!$result){
    $errorauthor = "Cet utilisateur n'existe pas.";
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
    $_SESSION['errorauthor']= $errorauthor;
    header("Location:/admin/forum/create");
} else {
    $_SESSION['blogname']= $blogname;
    $_SESSION['blogdesc']= $blogdesc;
    $query= $db->prepare("INSERT INTO ".PREFIX."forums (name, description, author) VALUES (:name,:description,:author)");
    $query->execute(["name"=>$blogname,"description"=>$blogdesc,"author"=>$author]);
    header("Location: /admin/forums");
}
