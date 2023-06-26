<?php

require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

$friend_id = $_GET['id'];

if (!isConnected()) {
    $_SESSION["message"] = "Vous devez être connecté pour effectuer cette action.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit();
}

if (empty($friend_id)) {
$_SESSION["message"] = "Une erreur est survenue.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit();
}

if (isConnected()) {

    $connection = connectToDB();

    $nquery = $connection->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
    $nquery->execute([':email' => $_SESSION['email']]);
    $user = $nquery->fetch(PDO::FETCH_ASSOC);

    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
    $queryPrepared->execute([
        ":user_id" => $user["id"],
        ":friend_id" => $friend_id,
    ]);
    $isFriend = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    if (!$isFriend) {
        $queryPrepared = $connection->prepare("INSERT INTO " . PREFIX . "user_friends (user_id, friend_id) VALUES (:user_id, :friend_id)");
        $queryPrepared->execute([
            "user_id" => $user["id"],
            "friend_id" => $friend_id,
        ]);
    } else {
        $queryPrepared = $connection->prepare("DELETE FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
        $queryPrepared->execute([
            "user_id" => $user["id"],
            "friend_id" => $friend_id,
        ]);
    }

    header("Location: /user?id=" . $_GET["id"]);
}