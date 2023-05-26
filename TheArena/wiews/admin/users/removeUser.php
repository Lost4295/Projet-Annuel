<?php
session_start();

require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";


redirectIfNotAdmin();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
$connect = connectToDB();
$queryPrepared = $connect->prepare("DELETE FROM ". PREFIX ."users WHERE id=:id");
$queryPrepared->execute(["id"=> $id]);
}
header("Location : /admin/users");