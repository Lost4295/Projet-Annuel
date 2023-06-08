<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';



if (
    isset($_POST["price"]) && $_POST["price"] == "1"
) {
    $_POST["valueprice"] = 0;
}
if (
    count($_POST) != 7
    || empty($_POST["name"])
    || !isset($_POST["price"])
    || empty($_POST["date"])
    || !isset($_POST["valueprice"])
    || !isset($_POST["description"])
    || !isset($_POST["event"])
    || !isset($_POST["id"])
) {
    print_r($_POST);
    die("Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name = $_POST["name"];
$type = $_POST["price"];
$priceint = intval($_POST["valueprice"]);
$pricefloat = floatval($_POST["valueprice"]);
$date = $_POST["date"];
$description = $_POST["description"];
$eventname = $_POST["event"];
$id = $_POST["id"];
$errorname = "";
$errorprice = "";
$errortype = "";
$errordate = "";
$errordescription = "";


$possibleTypes = ["1", "2"];

if (!in_array($type, $possibleTypes)) {
    $errortype = "Le type de tournoi n'est pas valide.";
}
if ($name == "" || $name == "/^ *$/") {
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

if ($priceint < 0. || $pricefloat < 0.) {
    $errorprice = "Le prix ne peut pas être négatif.";
}

if (empty($priceint) && empty($pricefloat)) {
    $price = 0;
} elseif ($priceint != $pricefloat) {
    $price = $pricefloat;
} else {
    $price = $priceint;
}


if ($type==2 && $price == 0) {
    $errorprice = "Le prix ne peut pas être nul pour un tournoi payant.";
}


if (strlen($description) > 700) {
    $errordescription = "La description doit faire moins de 700 caractères.";
}


$dateExploded = explode("-", $date);
$hour = substr($dateExploded[2], 3);
$day = substr($dateExploded[2], 0, 2);
if (!checkdate($dateExploded[1], $day, $dateExploded[0])) {
    $errordate = "Format de date incorrect";
} else {
    $todaySeconds = time();
    $dateSeconds = strtotime($date);
    $timeSeconds = $todaySeconds - $dateSeconds;
    $time = $timeSeconds / 60 / 60 / 24 / 365.25;

    if ($time >= 0) {
        $errordate = "La date est dans le passé. Impossible de faire un tournoi dans le passé !";
    } elseif ($time <= -3.) {
        $errordate = "La date est trop lointaine. Essayez de mettre une date inférieure à 3 ans, avant le" . $fmt->format(new DateTime("+3 years")) . " !";
    }
}


if (empty($errorname) && empty($errorprice) && empty($errordate) && empty($errordescription)&& empty($errortype)) {
    $error = false;
} else {
    $error = true;
}


if ($error) {
    $_SESSION['errorname'] = $errorname;
    $_SESSION['errortype'] = $errortype;
    $_SESSION['errorprice'] = $errorprice;
    $_SESSION['errordate'] = $errordate;
    $_SESSION['errordescription'] = $errordescription;
    header("Location: /admin_tournament_update?id=" . $id);
} else {
    $db = connectToDB();
    $queryPrepared = $db->prepare("UPDATE " . PREFIX . "tournaments SET name=:nom, price=:price, description=:description, event_type=:event_type, event_id=:event_id, date=:date WHERE id=:id");
    $queryPrepared->execute([
        "nom" => $name,
        "price" => $price,
        "description" => $description,
        "event_type" => $type,
        "event_id" => $eventname,
        "date" => $date,
        "id" => $id
    ]);
    $_SESSION['message'] = "Le tournoi a bien été modifié.";
    $_SESSION['message_type'] = "success";
    header("Location: /admin_tournaments");
}
