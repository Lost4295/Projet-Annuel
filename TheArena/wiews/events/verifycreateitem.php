<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST)!=4
    ||empty($_POST["name"])
    ||empty($_POST["price"])
    ||!isset($_POST["description"])
    ||!isset($_POST["shop_id"])
) { print_r($_POST);
    die(
        "Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name=$_POST["name"];
$price=$_POST["price"];
$description=$_POST["description"];
$errorname="";
$errorprice="";
$errordescription="";


if ($price<0) {
    $errorprice="Le prix ne peut pas être négatif.";
}
if (is_integer($price)||is_float($price)) {
    $errorprice="Veuillez entrer des valeurs numériques.";
}


if ($description=="") {
    $errordescription="La description ne peut pas être vide.";
}

if (strlen($description)<10) {
    $errordescription="La description doit faire au moins 10 caractères.";
}

if (strlen($description)>700) {
    $errordescription="La description doit faire moins de 700 caractères.";
}

if (!empty($errorname)||!empty($errorprice)||!empty($errordescription)||!empty($errorimage)) {
    $error=false;
} else {
    $error=true;
}

//FIXME: Add the item to the database
if (!$error) {
    $_SESSION['errorname']= $errorname;
    $_SESSION['errorprice']= $errorprice;
    $_SESSION['errorimage']= $errorimage;
    $_SESSION['errordescription']= $errordescription;
    header("Location: /");
} else {
    $_SESSION['name']= $name;
    $_SESSION['price']= $price;
    $_SESSION['image']= $image;
    $_SESSION['description']= $description;
    $db = connectToDB();
    $queryPrepared=$db->prepare("INSERT INTO ".PREFIX."items (name, price, description, image,shop_id) VALUES (:name, :price, :description, :image,:shop_id)");
    $queryPrepared->execute([
        ":name"=>$name,
        ":price"=>$price,
        ":description"=>$description,
        ":image"=>$image,
        ":shop_id"=>$shop_id
    ]);
    header("Location: /");
}

