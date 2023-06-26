<?php
include_once $_SERVER['DOCUMENT_ROOT']."/core/functions.php";

$connection = connectToDB();
$queryPrepared = $connection->prepare("UPDATE " . PREFIX . "users SET activeonsite=0 WHERE email=:email");
$queryPrepared->execute([
    "email" => $_SESSION['email']
]);
$deleter = $connection->prepare('DELETE FROM ' . PREFIX . 'connected_users WHERE user_id = :id');
$deleter->execute([
    "id" => $_SESSION['id']
]);
session_destroy();
session_unset();
session_start();
$_SESSION['message']="Vous avez été déconnecté.";
header("Location: /");
