<?php
session_start();
require('functions.php');

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if ($contentType=== "application/json"){
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    if (is_array($decoded)){
        $_POST = $decoded;
    } else {
        die("Le format de la requête est invalide.");
    }
}

if (
    count($_POST)!=5
    ||!isset($_POST["type"])
    ||empty($_POST["username"])
    ||empty($_POST["email"])
    ||empty($_POST["password"])
    ||empty($_POST["confirmPassword"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$type=$_POST["type"];
$username=$_POST["username"];
$email=strtolower(trim($_POST["email"]));
$pwd=$_POST["password"];
$confirmpwd=$_POST["confirmPassword"];
$errortype="";
$errorusername="";
$erroremail="";
$errorpwd="";
$errorpwdconfirm="";

$types=[1,2];

if (!in_array($type, $types)) {
    $errortype="Ce rôle n'existe pas.";
} else {
    $fintype=[];
    switch ($type) {
        case 2:
            $fintype['nom']="Organisateur";
            $fintype['scope']=ORGANIZER;// orga
            break;
        default:
        case 1:
            $fintype['scope']=PLAYER;//joueur
            $fintype['nom']="Joueur";
            break;
    }
    $db=connectToDB();
    $queryPrepared = $db->prepare(" SELECT count(*) FROM ".PREFIX."users");
    $queryPrepared->execute();
    $result=$queryPrepared->fetch();
    if (count($result)<=2) {
        $fintype['scope']=SUPADMIN;// le scope super admin
        $fintype['nom']="Super-Administrateur";
    } elseif (count($result)<=6) {
        $fintype['scope']=ADMIN;// le scope admin
        $fintype['nom']="Administrateur";
    }
}

if (strlen($username)<3) {
    $errorusername="Ce nom d'utilisateur est trop court.";
}
if (strlen($username)>30) {
    $errorusername="Ce nom d'utilisateur est trop long.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroremail = "L'email est incorrect.";
} else {
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
$table=[];
if (!empty($errortype)||!empty($errorusername)||!empty($errorpwd)||!empty($errorpwdconfirm)||!empty($erroremail)) {
    $error=true;
} else {
    $error=false;
}

if ($error) {
    
    $table['errortype']= $errortype;
    $table['errorusername']= $errorusername;
    $table['erroremail']= $erroremail;
    $table['errorpwd']= $errorpwd;
    $table['errorpwdconfirm']= $errorpwdconfirm;
} else{
    $_SESSION['type']=$fintype;
}

header('Content-Type: application/json');
echo json_encode($table);

