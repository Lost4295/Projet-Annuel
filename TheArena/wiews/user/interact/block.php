<?php

require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

$blocked_id = $_GET['id'];

if (!isConnected()) {
    $_SESSION["message"] = "Vous devez être connecté pour effectuer cette action.";
    $_SESSION["message_type"] = "danger";
    header("Location: /");
    exit();
}

if (empty($blocked_id)) {
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

    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users_blocked WHERE user_id=:user_id AND blocked_id=:blocked_id");
    $queryPrepared->execute([
        ":user_id" => $user["id"],
        ":blocked_id" => $blocked_id
    ]);
    $liked = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    if ($liked) {
        $queryPrepared = $connection->prepare("DELETE FROM " . PREFIX . "users_blocked WHERE user_id=:user_id AND blocked_id=:blocked_id");
        $queryPrepared->execute([
            "user_id" => $user["id"],
            "blocked_id" => $blocked_id
        ]);
    } else {
        $queryPrepared = $connection->prepare("INSERT INTO " . PREFIX . "users_blocked (user_id, blocked_id) VALUES (:user_id, :blocked_id)");
        $queryPrepared->execute([
            "user_id" => $user["id"],
            "blocked_id" => $blocked_id
        ]);
    }

    header("Location: /user?id=" . $_GET["id"]);
}