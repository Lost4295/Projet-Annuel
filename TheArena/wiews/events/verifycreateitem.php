<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST) != 6
    || empty($_POST["name"])
    || !isset($_POST["price"])
    || !isset($_POST["description"])
    || !isset($_POST["shop_id"])
    || !isset($_POST["type"])
    || !isset($_POST["eventname"])
) {
    print_r($_POST);
    print_r($_FILES);
    die("Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

$name = $_POST["name"];
$priceint = intval($_POST["price"]);
$pricefloat = floatval($_POST["price"]);
$description = $_POST["description"];
$shop_id = $_POST["shop_id"];
$type = $_POST["type"];
$eventname = $_POST["eventname"];
$errorname = "";
$errorprice = "";
$errordescription = "";
$errorimage = "";
$errortype = "";

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


$possibleTypes = [0, 1];

if (!in_array($type, $possibleTypes)) {
    $errortype = "Le type n'est pas correct.";
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

$dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\items\\';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $tmpName = $_FILES['image']['tmp_name'];
    $name = $_FILES['image']['name'];
    $type = $_FILES['image']['type'];
    $image = encodeImage($tmpName, $type);

    move_uploaded_file($tmpName, $dirname . $name);
} elseif ($_FILES['image']['error'] != 0) {
    $image = encodeImage($_SERVER['DOCUMENT_ROOT'] . '\\img\\placeholder_item.jpg', 'jpg');
} else {
    $errorimage = "L'image n'est pas valide.";
}

$db = connectToDB();


if (!empty($errorname) || !empty($errorprice) || !empty($errordescription) || !empty($errorimage) || !empty($errortype)) {
    $error = false;
} else {
    $error = true;
}

if (!$error) {
    $_SESSION['errorname'] = $errorname;
    $_SESSION['errorprice'] = $errorprice;
    $_SESSION['errorimage'] = $errorimage;
    $_SESSION['errordescription'] = $errordescription;
    $_SESSION['errortype'] = $errortype;
    header("Location: /event_shop_create_item?shop=" . $shop_id);
} else {
    $_SESSION['name'] = $name;
    $_SESSION['price'] = $price;
    $_SESSION['image'] = $image;
    $_SESSION['description'] = $description;
    $db = connectToDB();
    $queryPrepared = $db->prepare("INSERT INTO " . PREFIX . "products (nom, price, description, image,shop_id,type) VALUES (:nom, :price, :description, :image,:shop_id,:type)");
    $queryPrepared->execute([
        "nom" => $name,
        "price" => $price,
        "description" => $description,
        "image" => $image,
        "shop_id" => $shop_id,
        "type" => $type,
    ]);
    $_SESSION['message'] = "L'item a bien été créé.";
    $_SESSION['message_type'] = "success";
    header("Location: /event_shop?shop=" . $shop_id . "&name=". $eventname);
}
