<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";

$id = $_SESSION['id'];
$searchTerm = $_POST['searchTerm'];
$db = connectToDB();
$lequerie = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE NOT id =:id AND visibility = 2 AND username LIKE :search");
$lequerie->execute([
    ":search" => $searchTerm,
    ":id" => $id,
]);
$output = "";
$result = $lequerie->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    include_once "data.php";
} else {
    $output .= 'Aucun utilisateur ne correspond à votre recherche.';
}
echo $output;
