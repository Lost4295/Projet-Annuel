<?php
// friend : 4 états : 0 = demande envoyée, 1 = demande acceptée (amis mais x sait pas), 2 = amis qui se savent, -1 : refusé
//
// actions à mettre add, cancel (une demande envoyée), accept, refuse, remove (un ami) ok (pour dire qu'on a vu la demande),

require $_SERVER['DOCUMENT_ROOT'] . '/core/formatter.php';

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

if (isConnected() && !empty($friend_id) && $friend_id != $_SESSION['id'] && isset($_GET['action']) && !empty($_GET['action'])) {

    $action = $_GET['action'];
    $connection = connectToDB();

    $nquery = $connection->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `email`=:email');
    $nquery->execute([':email' => $_SESSION['email']]);
    $sender = $nquery->fetch(PDO::FETCH_ASSOC);
    $queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
    $queryPrepared->execute([
        ":user_id" => $sender["id"],
        ":friend_id" => $friend_id,
    ]);
    $isFriend = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    switch($action){
        case 'add':
        $queryPrepared = $connection->prepare("INSERT INTO " . PREFIX . "user_friends (user_id, friend_id, accepted) VALUES (:user_id, :friend_id, :accepted)");
        $queryPrepared->execute([
            "user_id" => $sender["id"],
            "friend_id" => $friend_id,
            "accepted" => 0,
        ]);
        $_SESSION["message"] = "Demande d'ami envoyée.";
        $_SESSION["message_type"] = "success";
        header("Location: /user?id=" . $_GET["id"]);
        break;
        case 'cancel':
        $queryPrepared = $connection->prepare("DELETE FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id AND accepted = 0");
        $queryPrepared->execute([
            "user_id" => $sender["id"],
            "friend_id" => $friend_id,
        ]);
        $_SESSION["message"] = "Demande d'ami annulée.";
        $_SESSION["message_type"] = "info";
        header("Location: /user?id=" . $_GET["id"]);
        break;
        case 'accept':
        $queryPrepared = $connection->prepare("UPDATE " . PREFIX . "user_friends SET accepted=1 WHERE user_id=:user_id AND friend_id=:friend_id");
        $queryPrepared->execute([
            "user_id" =>$friend_id,
            "friend_id" => $sender["id"],
        ]);
        $queryPrepared = $connection->prepare("INSERT INTO " . PREFIX . "user_friends (user_id, friend_id, accepted) VALUES (:user_id, :friend_id, :accepted)");
        $queryPrepared->execute([
            "user_id" => $sender["id"],
            "friend_id" => $friend_id,
            "accepted" => 2,
        ]);
        $_SESSION["message"] = "Demande d'ami acceptée.". formatUsers($friend_id) . " est maintenant votre ami.";
        $_SESSION["message_type"] = "success";
        header("Location: /me");
        break;
        case 'refuse':
            $queryPrepared = $connection->prepare("UPDATE " . PREFIX . "user_friends SET accepted=-1 WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                "user_id" => $sender["id"],
                "friend_id" => $friend_id,
            ]);
            $_SESSION["message"] = "Demande d'ami refusée.";
            $_SESSION["message_type"] = "info";
            header("Location: /me");
        break;
        case 'remove':
            $queryPrepared = $connection->prepare("DELETE FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                "user_id" => $sender["id"],
                "friend_id" => $friend_id,
            ]);
            $queryPrepared = $connection->prepare("DELETE FROM " . PREFIX . "user_friends WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                "user_id" => $friend_id,
                "friend_id" => $sender["id"],
            ]);
            $_SESSION["message"] = "Vous n'êtes plus ami avec " . formatUsers($friend_id) . ".";
            $_SESSION["message_type"] = "info";
        break;
        case 'ok':
            $queryPrepared = $connection->prepare("UPDATE " . PREFIX . "user_friends SET accepted=2 WHERE user_id=:user_id AND friend_id=:friend_id");
            $queryPrepared->execute([
                "user_id" => $sender["id"],
                "friend_id" => $friend_id,
            ]);
            header("Location: /me");
        break;
    }
}
header("Location: /");