<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (!isset($_POST['newsletter'])) {
    $_SESSION['newsletter']=1;
    $_POST['newsletter']=1;
}
if (
    count($_POST)!=8
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


$pseudo=$_POST["pseudo"];
$email=strtolower(trim($_POST["email"]));
$pwd=$_POST["pwd"];
$id=$_POST["id"];
$confirmpwd=$_POST["confirmpwd"];
$about=$_POST["about"];
$visibility=$_POST["visibility"];
$erroravatar="";
$errorabout="";
$errorpseudo="";
$erroremail="";
$errorpwd="";
$errorpwdconfirm="";
$errorvisibility="";

$possibleVisibility = [2,1];

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
        $erroremail="Vous n'avez pas renseigné le bon email. Si vous souhaitez changer d'email, merci de contacter un administrateur via la page de contact.";
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




$dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\users\\';

$queryPrepared = $db->prepare("SELECT avatar FROM ".PREFIX."users WHERE id=:id");
$queryPrepared->execute([
    "id"=>$id
]);
$result=$queryPrepared->fetch(PDO::FETCH_ASSOC);
$baseavatar=$result['avatar'];


if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $tmpName = $_FILES['avatar']['tmp_name'];
    $name = $_FILES['avatar']['name'];
    $type = $_FILES['avatar']['type'];
    $avatar= encodeImage($tmpName, $type);

    move_uploaded_file($tmpName, $dirname . $name);
} elseif (isset($_FILES['avatar']) && $_FILES['avatar']['error'] != 0) {
    $uploadedImage = encodeImage($_SERVER['DOCUMENT_ROOT'].'\\img\\placeholder_user.png', 'png');
    if ($baseavatar != $uploadedImage){
        $avatar = $baseavatar;
    } else {
        $avatar = $uploadedImage;
    }
}

if (!empty($erroravatar)||!empty($errorpseudo)||!empty($errorpwd)||!empty($errorpwdconfirm)||!empty($erroremail)||!empty($errorabout)||!empty($errorvisibility)) {
    $error=false;
} else {
    $error=true;
}


if (!$error) {
    $_SESSION['erroravatar']= $erroravatar;
    $_SESSION['errorpseudo']= $errorpseudo;
    $_SESSION['erroremail']= $erroremail;
    $_SESSION['errorpwd']= $errorpwd;
    $_SESSION['errorabout']= $errorabout;
    $_SESSION['errorpwdconfirm']= $errorpwdconfirm;
    header("Location: /me_modify");
} else {
    unsetSessionErrors();
    $queryPrepared = $db->prepare("UPDATE ".PREFIX."users SET avatar=:avatar, username=:username, email=:email, password=:password, about=:about, visibility=:visibility, update_at=:update_at WHERE id=:id");
    $queryPrepared->execute([
        "avatar"=>$avatar,
        "username"=>$pseudo,
        "email"=>$email,
        "password"=>password_hash($pwd, PASSWORD_DEFAULT),
        "about"=>$about,
        "visibility"=>$visibility,
        "udpate_at"=>time(),
        "id"=>$id
    ]);
    $_SESSION['message'] = "Votre profil a bien été modifié.";
    $_SESSION["message_type"]="success";
    header("Location:   /me");
}
