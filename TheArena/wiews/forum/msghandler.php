<?php

require_once $_SERVER['DOCUMENT_ROOT']."/core/functions.php";

if (
    count($_POST)!= 3
    || !isset($_POST['id'])
    || !isset($_POST['user'])
    || !isset($_POST['message'])
){
    $_SESSION["message"] = "Erreur lors de l'envoi du message";
    $_SESSION["message_type"] = "danger";
    header("Location: /forum?id=".$_POST['id']);
    die('ng');
    exit();
} else {
    if ($_POST['message']==""){
        $_SESSION["message"] = "Erreur lors de l'envoi du message";
        $_SESSION["message_type"] = "danger";
        header("Location: /forum?id=".$_POST['id']);
    die('ng');

        exit();
    }
    $date = date("Y-m-d H:i:s");
    $db= connectToDB();
    $query= $db->prepare("INSERT INTO ".PREFIX."forum_reponses (id_forum, user_id, message, date_reponse) VALUES (:id_forum, :author, :message, :date_reponse)");
    $query->execute([
        "id_forum" => $_POST['id'],
        "author" => $_POST['user'],
        "date_reponse" => $date,
        "message" => $_POST['message']
    ]);
    $query = $db->prepare("UPDATE ".PREFIX."forums SET date_last_message = :date_last_message WHERE id = :id");
    $query->execute([
        "date_last_message" => $date,
        "id" => $_POST['id']
    ]);
    $_SESSION["message"] = "Message envoyé !";
    $_SESSION["message_type"] = "success";
    header("Location: /forum?id=".$_POST['id']);
    die('gg!');
    exit();
}
