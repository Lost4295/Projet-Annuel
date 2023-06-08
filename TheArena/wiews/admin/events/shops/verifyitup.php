<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST) != 8
    || empty($_POST["name"])
    || !isset($_POST["price"])
    || !isset($_POST["description"])
    || !isset($_POST["shop_id"])
    || !isset($_POST["id"])
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
$id= $_POST['id'];
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

if (!preg_match("#^([a-zA-Z]+ ?)*$#", $name)) {
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

$db = connectToDB();

$queryPrepared = $db->prepare("SELECT image FROM ".PREFIX."products WHERE id=:id");
$queryPrepared->execute([
    "id"=>$id
]);
$result=$queryPrepared->fetch(PDO::FETCH_ASSOC);
$baseimage=$result['image'];

$dirname = $_SERVER['DOCUMENT_ROOT'] . '\uploads\\items\\';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $tmpName = $_FILES['image']['tmp_name'];
    $fname = $_FILES['image']['name'];
    $type = $_FILES['image']['type'];
    $image = encodeImage($tmpName, $type);

    move_uploaded_file($tmpName, $dirname . $fname);
} elseif (isset($_FILES['image']) && $_FILES['image']['error'] != 0) {
    $uploadedImage = encodeImage($_SERVER['DOCUMENT_ROOT'].'\\img\\placeholder_item.jpg', 'jpg');
    if ($baseimage != $uploadedImage){
        $image = $baseimage;
    } else {
        $image = $uploadedImage;
    }
}




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
    header("Location: /admin/items/create?id=" . $shop_id);
} else {
    $_SESSION['name'] = $name;
    $_SESSION['price'] = $price;
    $_SESSION['image'] = $image;
    $_SESSION['description'] = $description;
    $queryPrepared = $db->prepare("UPDATE " . PREFIX . "products SET nom=:nom,  price=:price,  description=:description,  image=:image, shop_id=:shop_id, type=:type WHERE id =:id");
    $queryPrepared->execute([
        "nom" => $name,
        "price" => $price,
        "description" => $description,
        "image" => $image,
        "shop_id" => $shop_id,
        "type" => $type,
        "id"=>$id
    ]);
    $_SESSION['message'] = "L'item a bien été créé.";
    $_SESSION['message_type'] = "success";
    header("Location: /admin/shops/read?id=" . $shop_id );
}
