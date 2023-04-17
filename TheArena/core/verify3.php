<?php
session_start();

if (
    count($_POST)!=3
    ||empty($_POST["cgu"])
    ||empty($_POST["newsletter"])
    ||empty($_POST["ok"])
) {
    print_r($_POST);
    die("
    Il ne vous est pas possible de terminer l'action. Merci de réessayer.
     Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
     puis de contacter un administrateur.");
}

$newsletterNotProcessed = $_POST["newsletter"];
$errornewsletter="";

if ($newsletterNotProcessed== 1) {
    $newsletter=true;
} elseif ($newsletterNotProcessed == 0) {
    $newsletter = false;
} else {
    $errornewsletter = "Format de données invalide.";
}

if (!empty($errornewsletter)) {
    $_SESSION['errornewsletter']= $errornewsletter;
    header("Location: ../wiews/fininscription.php");
} else {
    $query=$connection->prepare("INSERT INTO zeya_users
    (type,username,email,pwd,firstname,lastname,birthdate,phonenumber,address,cp,country) VALUES
    (:type,:username,:email,:pwd,:firstname,:lastname,:email,:birthdate,:phonenumber,:address,:cp,:country)");
    $query->execute([
        "type" =>$_SESSION['type'],
        "username"=>$_SESSION['username'],
        "email"=>$_SESSION['email'],
        "pwd"=>$_SESSION['pwd'],
        "firstname"=>$_SESSION['firstname'],
        "lastname"=>$_SESSION['lastname'],
        "birthdate"=>$_SESSION['birthdate'],
        "phonenumber"=>$_SESSION['phonenumber'],
        "address"=>$_SESSION['address'] . ", ". $_SESSION['city'],
        "cp"=>$_SESSION['cp'],
        "country"=>$_SESSION['country'],
        "newsletter"=>$newsletter
    ]);
    header("Location: ../wiews/index.php");
}
