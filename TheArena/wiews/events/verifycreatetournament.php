<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';


if (
    count($_POST)!=5
    ||empty($_POST["name"])
    ||!isset($_POST["type"])
    ||empty($_POST["date"])
    ||!isset($_POST["description"])
    ||!isset($_POST["event"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name=$_POST["name"];
$priceint = intval($_POST["price"]);
$pricefloat = floatval($_POST["price"]);
$date=$_POST["date"];
$description=$_POST["description"];
$eventname=$_POST["event"];
$errorname="";
$errorprice="";
$errordate="";
$errordescription="";


if ($name == "") {
    $errorname = "Le nom ne peut pas être vide.";
}

if (strlen($name) <= 2) {
    $errorname = "Le nom doit faire au moins 3 caractères.";
}

if (strlen($name) >= 50) {
    $errorname = "Le nom ne doit pas faire plus de 50 caractères.";
}

if (!preg_match("#^[a-zA-Z]*$#", $name)) {
    $errorname = "Le nom ne doit contenir que des lettres.";
}

if ($priceint < 0 || $pricefloat < 0) {
    $errorprice = "Le prix ne peut pas être négatif.";
}

if (empty($priceint) && empty($pricefloat)) {
    $price = 0;
} elseif ($priceint != $pricefloat) {
    $price = $pricefloat;
} else {
    $price = $priceint;
}


if ($description == "") {
    $errordescription = "La description ne peut pas être vide.";
}

if (strlen($description) < 10) {
    $errordescription = "La description doit faire au moins 10 caractères.";
}

if (strlen($description) > 700) {
    $errordescription = "La description doit faire moins de 700 caractères.";
}


$dateExploded=explode("-", $date);
if (!checkdate($dateExploded[1], $dateExploded[2], $dateExploded[0])) {
$errordate= "Format de date incorrect";
} else {
    $todaySeconds= time();
    $dateSeconds = strtotime($date);
    $timeSeconds= $todaySeconds - $dateSeconds;
    $time = $timeSeconds/60/60/24/365.25;
    if (($time <= 0.)) {
        $errordate = "La date est dans le passé. Impossible de faire un tournoi dans le passé !";
    }
    if (($time >= 3)) {
        $errordate = "La date est trop lointaine. Essayez de mettre une date inférieure à 3 ans, avant " . $fmt->format(new DateTime("+3 years"))." !";
    }
}


if (!empty($errorname)||!empty($errorprice)||!empty($errordate)||!empty($errordescription)) {
    $error=false;
} else {
    $error=true;
}

//FIXME: Add the tournament to the database
if (!$error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errorprice']= $errorprice;
    $_SESSION['errordate']= $errordate;
    $_SESSION['errordescription']= $errordescription;
    header("Location: /event/tournament/create?name=" . $eventname);

} else {
    $queryPrepared = $db->prepare("INSERT INTO " . PREFIX . "tournaments (name, price, description, type, event) VALUES (:nom, :price, :description,:type,:event)");
    $queryPrepared->execute([
        "nom" => $name,
        "price" => $price,
        "description" => $description,
        "type" => $type,
        "event" => $eventname
    ]);
    $_SESSION['message'] = "Le tournoi a bien été créé.";
    $_SESSION['message_type'] = "success";
    header("/event?name=".$eventname);
}

