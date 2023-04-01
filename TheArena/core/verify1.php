<?php 
session_start();
require('pdo.php');
if(
    count($_POST)!=5
    ||!isset($_POST["type"])
    ||empty($_POST["username"])
    ||empty($_POST["email"])
    ||empty($_POST["pwd"])
    ||empty($_POST["confirmpwd"])
)
{print_r($_POST );
    die("Il ne vous est pas possible de terminer l'action. Merci de réessayer. Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations, puis de contacter un administrateur.");
}

$type=$_POST["type"];
$username=$_POST["username"];
$email=strtolower(trim($_POST["email"]));
$pwd=$_POST["pwd"];
$confirmpwd=$_POST["confirmpwd"];
$errortype="";
$errorusername="";
$erroremail="";
$errorpwd="";
$errorpwdconfirm="";

$types=[0,1];

if (!in_array($type, $types)){
    $errortype="Ce rôle n'existe pas.";
}

if(strlen($username)<3){
    $errorusername="Ce nom d'utilisateur est trop court.";
}
if(strlen($username)>30){
    $errorusername="Ce nom d'utilisateur est trop long.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $erroremail = "L'email est incorrect.";
}else{
    $db = connectToDB();
    $queryPrepared = $db->prepare(" SELECT id FROM zeya_users WHERE email=:email");
    $queryPrepared->execute([
        "email"=>$email
    ]);
    $result=$queryPrepared->fetch();
    if(!empty($result)){
        $erroremail="L'email est déjà utilisé.";
    }
}

if(strlen($pwd)< 8 || !preg_match("#[a-z]#", $pwd)|| !preg_match("#[A-Z]#", $pwd) || !preg_match("#[0-9]#", $pwd)){
    $errorpwd="Votre mot de passe doit faire au minimum 8 caractères avec des minuscules, des majuscules et des chiffres.";
}

if ($pwd != $confirmpwd){
    $errorpwdconfirm="Le mot de passe n'est pas bien copié.";
}

if(!empty($errortype)||!empty($errorusername)||!empty($errorpwd)||!empty($errorpwdconfirm)||!empty($erroremail)){
    $error=false;
} else {
    $error=true;
}


if(!$error){
    $_SESSION['errortype']= $errortype;
    $_SESSION['errorusername']= $errorusername;
    $_SESSION['erroremail']= $erroremail;
    $_SESSION['errorpwd']= $errorpwd;
    $_SESSION['errorpwdconfirm']= $errorpwdconfirm;
    header("Location: ../wiews/inscription.php");
} else {
    $_SESSION['type']= $type;
    $_SESSION['username']= $username;
    $_SESSION['email']= $email;
    $_SESSION['pwd']= $pwd;
    header("Location: ../wiews/suiteinscription.php");
}