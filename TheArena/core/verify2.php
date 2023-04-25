<?php
session_start();
require('functions.php');
if (isset($_POST)) {
if (
    count($_POST)!=8
    ||empty($_POST["firstname"])
    ||empty($_POST["lastname"])
    ||empty($_POST["birthdate"])
    ||empty($_POST["phonenumber"])
    ||empty($_POST["address"])
    ||empty($_POST["cp"])
    ||empty($_POST["city"])
    ||empty($_POST["country"])
) {
    print_r($_POST);
    die("
        Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais,
         merci de vérifier vos informations, puis de contacter un administrateur.
        ");
}


$firstname= ucwords(strtoupper(trim($_POST["firstname"])));
$lastname= strtoupper(trim($_POST["lastname"]));
$birthdate=$_POST["birthdate"];
$phonenumber=$_POST["phonenumber"];
$address=$_POST["address"];
$cp=$_POST["cp"];
$city=$_POST["city"];
$country=substr($_POST["country"], 0, 1);
$errorfirstname="";
$errorlastname="";
$errorbirthdate="";
$errorphonenumber="";
$erroraddress="";
$errorcp="";
$errorcity="";
$errorcountry="";

if (strlen($lastname)<2) {
    $errorlastname= "Le nom doit faire plus de 2 caractères.";
}

if (strlen($firstname)<2) {
    $errorfirstname= "Le prénom doit faire plus de 2 caractères.";
}


$birthdateExploded=explode("-", $birthdate);
if (!checkdate($birthdateExploded[1], $birthdateExploded[2], $birthdateExploded[0])) {
$errorbirthdate= "Format de date incorrect";
} else {
    $todaySeconds= time();
    $birthdateSeconds = strtotime($birthdate);
    $ageSeconds= $todaySeconds - $birthdateSeconds;
    $age = $ageSeconds/60/60/24/365.25;
    if ($age < 16 || $age > 80) {
        $errorbirthdate = "Vous n'avez pas l'âge requis.";
    }
}



if (!preg_match("/^0[1-9](?:[ .-]?[\d]{2}){4}/", $phonenumber)) {
    $errorphonenumber="Le numéro est invalide.";
} else {
    $db = connectToDB();
    $queryPrepared = $db->prepare(" SELECT id FROM ".PREFIX."users WHERE phone=:phone");
    $queryPrepared->execute([
        "phone"=>$phonenumber
    ]);
    $result=$queryPrepared->fetch();
    if (!empty($result)) {
        $errorphonenumber="Le numéro de téléphone est déjà utilisé.";
    }
}

if (strlen($address) > 200) {
        $erroraddress= '200 carctères maximum.';
    } elseif (strlen($address) < 5) {
        $erroraddress= 'Il faut au moins 5 carctères.';
    } elseif (!preg_match("/^[A-z0-9 ]+$/", $address)) {
        $erroraddress= 'Carctères invalides. Caractères autorisés : A-z, 0-9, espace';
    }

if (!preg_match("/^[\d]{5}$/", $cp)) {
    $errorcp="Le code postal est invalide.";
}


if (
    !empty($errorfirstname)
    ||!empty($errorlastname)
    ||!empty($errorbirthdate)
    ||!empty($errorphonenumber)
    ||!empty($erroremail)
    ||!empty($errorcountry)
    ||!empty($errorcity)
    ||!empty($errorcp)
    ||!empty($erroraddress)) {
    $error=true;
} else {
    $error=false;
}


if ($error) {
    $_SESSION['errorfirstname']= $errorfirstname;
    $_SESSION['errorlastname']= $errorlastname;
    $_SESSION['errorbirthdate']= $errorbirthdate;
    $_SESSION['errorphonenumber']= $errorphonenumber;
    $_SESSION['erroraddress']= $erroraddress;
    $_SESSION['errorcp']= $errorcp;
    $_SESSION['errorcity']= $errorcity;
    $_SESSION['errorcountry']= $errorcountry;
    header("Location: ../wiews/register/suiteinscription.php");
} else {
    $_SESSION['firstname']= $firstname;
    $_SESSION['lastname']= $lastname;
    $_SESSION['birthdate']= $birthdate;
    $_SESSION['phonenumber']= $phonenumber;
    $_SESSION['address']= $address;
    $_SESSION['cp']= $cp;
    $_SESSION['city']= $city;
    $_SESSION['country']= $country;
    header("Location: ../wiews/register/fininscription.php");
}
}