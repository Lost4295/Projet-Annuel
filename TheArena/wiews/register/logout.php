<?php
include $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
session_start();
$connection = connectToDB();
$queryPrepared = $connection->prepare("UPDATE " . PREFIX . "users SET activeonsite=0 WHERE email=:email");
$queryPrepared->execute([
    "email" => $_SESSION['email']
]);
session_destroy();
session_unset();
session_start();
$_SESSION['message']="Vous avez été déconnecté.";
header("Location: /");
