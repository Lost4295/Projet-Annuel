<?php
include $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';
if (isset($_GET['id']) && isset($_GET["type"]) && !empty($_GET['id']) && !empty($_GET['type'])){
    $id=$_GET['id'];
    $type=$_GET['type'];
    $content=$_GET['content']??null;
    $possibleTypes = ["forumpost", "comment", "user", "event"];
    if (!in_array($type, $possibleTypes)){
            $_SESSION['message']=" Une erreur est survenue. Merci de réessayer.";
            $_SESSION['message_type']="danger";
        header("Location: /");
        exit();
    }
    $db = connectToDB();
if (isConnected()){
    $query = $db->prepare("SELECT id FROM ".PREFIX."users WHERE email = :email");
    $query->execute([
        "email" => $_SESSION["email"]
    ]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $uid = $user["id"];
}
    $queryPrepared = $db->prepare("INSERT INTO ".PREFIX."user_reports (reported_id, discr, content, user_id ) VALUES (:id, :type, :content, :user_id)");
    $queryPrepared->execute([
        ":id" => $id,
        ":type" => $type,
        ":content" => $content,
        ":user_id" => $uid??1
    ]);
    $_SESSION['message']=" Le signalement a bien été pris en compte. Merci de votre aide.";
    $_SESSION['message_type']="success";
    header("Location: /");
    exit();
} else {
    die("Une erreur est survenue.");
}