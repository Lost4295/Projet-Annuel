<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
if (
    isset($_POST['name']) && !empty($_POST['name']) &&
    isset($_POST["max_users"]) && !empty($_POST["max_users"]) &&
    isset($_POST['room']) &&
    (($_POST['room']==1 && isset($_POST['fulladdress']) && !empty($_POST['fulladdress']) &&
    isset($_POST['address']) && !empty($_POST['address']) &&
    isset($_POST['cp']) && !empty($_POST['cp']) &&
    isset($_POST['city']) && !empty($_POST['city']))|| $_POST['room']==0)
) {
echo 'ok';
} else {
    echo 'pas ok';
    
}
$name = $_POST['name'];
$room = $_POST['room'];
$max_users = $_POST['max_users'];
$fulladdress = $_POST['fulladdress']??'';
$address = $_POST['address']??'';
$cp = $_POST['cp']??'';
$city = $_POST['city']??'';
$errorname = '';
$errorfulladdress = '';
$erroraddress = '';
$errorcp = '';
$errorcity = '';
$errormax_users = '';

if (strlen($name) < 3) {
    $errorname = "Ce nom d'utilisateur est trop court.";
}
if (strlen($name) > 30) {
    $errorname = "Ce nom d'utilisateur est trop long.";
}
if ($room == 1) {
$fulladdressExploded=explode(",", $fulladdress);
if (count($fulladdressExploded) != 3) {
    $errorfulladdress= "L'adresse est invalide.";
} else {
    if (trim($address) != trim($fulladdressExploded[0])){
        $erroraddress= "L'adresse est invalide.";
    }
    if (trim($cp) != trim($fulladdressExploded[1])){
        $errorcp= "Le code postal est invalide.";
    } else {
        $depart = substr($cp, 0, 2);
    }
    if (trim($city) != trim($fulladdressExploded[2])){
        $errorcity= "La ville est invalide.";
    }
}
}
if ($max_users < 1) {
    $errormax_users = "Le nombre d'utilisateurs maximum est trop bas.";
}

if ($errorname != '' || $errorfulladdress != '' || $erroraddress != '' || $errorcp != '' || $errorcity != ''|| $errormax_users != '') {
    $_SESSION['errorname'] = $errorname;
    $_SESSION['errorfulladdress'] = $errorfulladdress;
    $_SESSION['erroraddress'] = $erroraddress;
    $_SESSION['errorcp'] = $errorcp;
    $_SESSION['errorcity'] = $errorcity;
    $_SESSION['errormaxusers'] = $errormax_users;
    header('Location: /event/room/create');
    exit();
} else {
    $bdd = connectToDB();
    $req = $bdd->prepare('INSERT INTO `'.PREFIX.'event_rooms` (`type`, `address`, `max_users`, `owner_id`, `name`) VALUES (:type, :address, :max_users, :owner_id, :name)');
    $req->execute(array(
        'name' => $name,
        'address' => $fulladdress,
        'owner_id' => $_SESSION['id'],
        'max_users' => $max_users,
        'type' => $room
    ));
    header('Location: /events');
    exit();
}