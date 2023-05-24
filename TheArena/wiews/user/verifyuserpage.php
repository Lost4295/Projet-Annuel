<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST)!=6
    ||empty($_POST["image"])
    ||empty($_POST["pseudo"])
    ||empty($_POST["email"])
    ||empty($_POST["pwd"])
    ||empty($_POST["confirmpwd"])
    ||empty($_POST["about"])
) { print_r($_POST); print_r($_FILES);
    $val=0;
            foreach ($_POST as $elem){
                $val+=1;
            }
            echo "<br> Nombre total de values =".$val."<br>";
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}


$image=$_POST["image"];
$pseudo=$_POST["pseudo"];
$email=strtolower(trim($_POST["email"]));
$pwd=$_POST["pwd"];
$confirmpwd=$_POST["confirmpwd"];
$about=$_POST["about"];
$errorimage="";
$errorabout="";
$errorpseudo="";
$erroremail="";
$errorpwd="";
$errorpwdconfirm="";



if (strlen($pseudo)<3) {
    $errorpseudo="Ce nom d'utilisateur est trop court.";
}
if (strlen($pseudo)>30) {
    $errorpseudo="Ce nom d'utilisateur est trop long.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroremail = "L'email est incorrect.";
} else {
    $db = connectToDB();
    $queryPrepared = $db->prepare(" SELECT id FROM ".PREFIX."users WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$email
    ]);
    $result=$queryPrepared->fetch();
    if (!empty($result)) {
        $erroremail="L'email est déjà utilisé.";
    }
}

if (strlen($pwd)< 8 || !preg_match("#[a-z]#", $pwd)|| !preg_match("#[A-Z]#", $pwd) || !preg_match("#[\d]#", $pwd)) {
    $errorpwd="
        Votre mot de passe doit faire au minimum 8 caractères avec des minuscules,
        des majuscules et des chiffres.";
}

if ($pwd != $confirmpwd) {
    $errorpwdconfirm="Le mot de passe n'est pas bien copié.";
}

if (!empty($errorimage)||!empty($errorpseudo)||!empty($errorpwd)||!empty($errorpwdconfirm)||!empty($erroremail)) {
    $error=false;
} else {
    $error=true;
}


if (!$error) {
    $_SESSION['errorimage']= $errorimage;
    $_SESSION['errorpseudo']= $errorpseudo;
    $_SESSION['erroremail']= $erroremail;
    $_SESSION['errorpwd']= $errorpwd;
    $_SESSION['errorabout']= $errorabout;
    $_SESSION['errorpwdconfirm']= $errorpwdconfirm;
    header("");
} else {
    $_SESSION['image']= $image;
    $_SESSION['pseudo']= $pseudo;
    $_SESSION['email']= $email;
    $_SESSION['pwd']= $pwd;
    $_SESSION['about']= $about;
    header("");
}
