<?php
session_start();
include 'functions.php';
if (isset($_POST)) {
if (!isset($_POST['newsletter'])) {
    $_SESSION['newsletter']=0;
    $_POST['newsletter']=0;
}
if (
    count($_POST)!=3
    ||empty($_POST["cgu"])
    ||!isset($_POST["newsletter"])
    ||empty($_POST["captcha"])
) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    die("
    Il ne vous est pas possible de terminer l'action. Merci de réessayer.
     Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
     puis de contacter un administrateur.");
}

$newsletterNotProcessed = $_POST["newsletter"];
$captcha = $_POST["captcha"];
$errornewsletter="";
$errorcaptcha="";


if ($newsletterNotProcessed== 1) {
    $newsletter=1;
} elseif ($newsletterNotProcessed == 0) {
    $newsletter = 0;
} else {
    $errornewsletter = "Format de données invalide.";
}

if ($captcha != $_SESSION['captcha']) {
    $errorcaptcha="Le captcha est incorrect.";
}

if (!empty($errornewsletter)|| !empty($errorcaptcha)) {$error=true;} else {$error=false;}

    if ($error) {
    $_SESSION['errornewsletter']= $errornewsletter;
    $_SESSION['errorcaptcha']= $errorcaptcha;
    header("Location: ../wiews/register/fininscription.php");
} else {
    $connection = connectToDB();
    $query=$connection->prepare("INSERT INTO ".PREFIX."users
    (scope,username,email,password,first_name,last_name,birthdate,phone,address,postal_code,country, newsletter)
    VALUES
    (
        :scope,:username,:email,:password,:first_name,:last_name,:birthdate,
        :phone,:address,:postal_code,:country,:newsletter
    )");
    $query->execute([
        "scope" =>$_SESSION['type'],
        "username"=>$_SESSION['username'],
        "email"=>$_SESSION['email'],
        "password"=>$_SESSION['pwd'],
        "first_name"=>$_SESSION['firstname'],
        "last_name"=>$_SESSION['lastname'],
        "birthdate"=>$_SESSION['birthdate'],
        "phone"=>$_SESSION['phonenumber'],
        "address"=>$_SESSION['address'] . ", ". $_SESSION['city'],
        "postal_code"=>$_SESSION['cp'],
        "country"=>$_SESSION['country'],
        "newsletter"=>$newsletter
    ]);
    unsetwhenRegistered();
    header("Location: ../wiews/index.php");
}

}