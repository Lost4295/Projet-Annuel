<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (!isset($_POST['newsletter'])) {
    $_SESSION['newsletter']=1;
    $_POST['newsletter']=1;
}
if (
    count($_POST)!=9
    ||empty($_POST["image"])
    ||empty($_POST["pseudo"])
    ||empty($_POST["email"])
    ||empty($_POST["pwd"])
    ||empty($_POST["id"])
    ||empty($_POST["confirmpwd"])
    ||empty($_POST["about"])
    ||empty($_POST["newsletter"])
    ||empty($_POST["visibility"])
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
$id=$_POST["id"];
$confirmpwd=$_POST["confirmpwd"];
$about=$_POST["about"];
$visibility=$_POST["visibility"];
$errorimage="";
$errorabout="";
$errorpseudo="";
$erroremail="";
$errorpwd="";
$errorpwdconfirm="";
$errorvisibility="";

$possibleVisibility = [0,1];

if (!in_array($visibility, $possibleVisibility)) {
    $errorvisibility="La visibilité n'est pas correcte.";
}

if (strlen($pseudo)<3) {
    $errorpseudo="Ce nom d'utilisateur est trop court.";
}
if (strlen($pseudo)>30) {
    $errorpseudo="Ce nom d'utilisateur est trop long.";
}

if (strlen($about)>500) {
    $errorabout="La description est trop longue.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroremail = "L'email est incorrect.";
} else {
    $db = connectToDB();
    $queryPrepared = $db->prepare(" SELECT id FROM ".PREFIX."users WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$email
    ]);
    $result=$queryPrepared->fetch(PDO::FETCH_ASSOC);
    if (($result['id'] != $id)) {
        $erroremail="Incorrect email.";
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

if (!empty($errorimage)||!empty($errorpseudo)||!empty($errorpwd)||!empty($errorpwdconfirm)||!empty($erroremail)||!empty($errorabout)||!empty($errorvisibility)) {
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
    header("Location: /me/modify");
} else {
    eraseSessionErrors();
    $_SESSION['image']= $image;
    $_SESSION['pseudo']= $pseudo;
    $_SESSION['email']= $email;
    $_SESSION['pwd']= $pwd;
    $_SESSION['about']= $about;
    header("Location:   /me");
}
