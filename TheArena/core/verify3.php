<?php
session_start();
include 'functions.php';
include 'sendmail.php';
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

$table=[];
    if ($error) {
    $table['errornewsletter']= $errornewsletter;
    $table['errorcaptcha']= $errorcaptcha;
    header("Location: ../wiews/register/fininscription.php"); // TODO : Finir pour avoir tout le côté mail
} else {
    $connection = connectToDB();
    $query=$connection->prepare("INSERT INTO ".PREFIX."users
    (scope,username,email,password,first_name,last_name,birthdate,phone,address,postal_code,country,newsletter
    ,activation_timeout,activation_code)
    VALUES
    (
        :scope,:username,:email,:password,:first_name,:last_name,:birthdate,
        :phone,:address,:postal_code,:country,:newsletter,:activation_timeout,:activation_code
    )");
    $query->execute([
        "scope" =>$_SESSION['type']["scope"],
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
        "newsletter"=>$newsletter,
        "activation_timeout"=> date("Y-m-d H:i:s", strtotime("+1 day")),
        "activation_code"=>password_hash(generateActivationCode(), PASSWORD_DEFAULT),
    ]);
    unsetwhenRegistered();
    //TODO: Envoyer un mail de validation, pour de vrai
    $activationCode = generateActivationCode();
    $subject='Validation du compte The Arena : '.$_SESSION['username'];
    $email=$_SESSION['email'];
    $url = "https://thearena.litecloud.fr/authentification?email=".$email."&activationCode=".$activationCode;
    $body='Clique sur le lien pour valider le compte ! <a href='.$url.'> Cliquer</a>';
    sendEmail($email, $subject, $body);
    header("Location: /");
}
return json_encode($table);
}
