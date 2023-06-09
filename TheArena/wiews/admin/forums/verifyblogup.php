<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST)!=4
    ||empty($_POST["blogname"])
    ||empty($_POST["blogdesc"])
    ||empty($_POST["author"])
    ||empty($_POST["id"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}


$blogname= trim($_POST["blogname"]);
$blogdesc= trim($_POST["blogdesc"]);
$author= $_POST["author"];
$id= $_POST["id"];
$errorname="";
$errordesc="";
$errorauthor="";

if (strlen($blogname)<3) {
    $errorname= "Le nom doit faire plus de 2 caractères.";
}
$db = connectToDB();
$query = $db->prepare("SELECT * FROM ".PREFIX."forums where name =:name");
$query->execute(['name'=>$blogname]);
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result>1) {
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


if (empty($errorname) && empty($errordesc)) {
    $error=false;
} else {
    $error=true;
}


if ($error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errordesc']= $errordesc;
    header("Location: /wiews_forum_update?id=".$id); 
} else {
    $query= $db->prepare("UPDATE ".PREFIX."forums SET name=:name, description=:description, author=:author WHERE id=:id");
    $query->execute(["name"=>$blogname,"description"=>$blogdesc,'author'=>$author, 'id'=>$id]);
    header("Location: /admin_forums");
}
