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

if (isset($_POST)) {
if (
    count($_POST)!=8
    ||empty($_POST["firstname"])
    ||empty($_POST["lastname"])
    ||empty($_POST["birthdate"])
    ||empty($_POST["phonenumber"])
    ||empty($_POST["address"])
    ||empty($_POST["fulladdress"])
    ||empty($_POST["cp"])
    ||empty($_POST["ville"])
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
$fulladdress=$_POST["fulladdress"];
$address=$_POST["address"];
$cp=$_POST["cp"];
$city=$_POST["ville"];
$errorfirstname="";
$errorlastname="";
$errorbirthdate="";
$errorphonenumber="";
$erroraddress="";
$errorcp="";
$errorcity="";

if (strlen($lastname)<2) {
    $errorlastname= "Le nom doit faire plus de 2 caractères.";
}

if (strlen($firstname)<2) {
    $errorfirstname= "Le prénom doit faire plus de 2 caractères.";
}

$fulladdressExploded=explode(",", $fulladdress);
if (count($fulladdressExploded) != 3) {
    $errorfulladdress= "L'adresse est invalide.";
} else {
    if (trim($address) != trim($fulladdressExploded[0])){
        $erroraddress= "L'adresse est invalide.";
    }
    if (trim($cp) != trim($fulladdressExploded[1])){
        $errorcp= "Le code postal est invalide.";
    }
    if (trim($city) != trim($fulladdressExploded[2])){
        $errorcity= "La ville est invalide.";
    }
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



if (!preg_match("/^0[1-9](?:[ .-]?[\d]{2}){4}$/", $phonenumber)) {
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
    } elseif (!preg_match("/^[A-Za-z0-9' \-éèàù]+$/", $address)) {
        $erroraddress= 'Carctères invalides. Caractères autorisés : A-z, 0-9, espace, \' et -';
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
    ||!empty($errorcity)
    ||!empty($errorcp)
    ||!empty($erroraddress)) {
    $error=true;
} else {
    $error=false;
}

$table =[];
if ($error) {
    $table['errorfirstname']= $errorfirstname;
    $table['errorlastname']= $errorlastname;
    $table['errorbirthdate']= $errorbirthdate;
    $table['errorphonenumber']= $errorphonenumber;
    $table['erroraddress']= $erroraddress;
    $table['errorcp']= $errorcp;
    $table['errorcity']= $errorcity;
    $table['cp']= $cp;
    $table['cpex']= $fulladdressExploded[1];
    $table["fae"]= $fulladdressExploded;
    
}



header('Content-Type: application/json');
echo json_encode($table);

}
