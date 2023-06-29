<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT']."/core/functions.php";

    redirectIfNotConnected();
    $userid = $_SESSION['id'];
    $db = connectToDB();
    $sql = $db->prepare("SELECT * FROM ".PREFIX."users WHERE NOT id = :id AND visibility = 2 ORDER BY id DESC"); //TODO ajouter la même requête, mais seulement pour trouver aussi les amis
    $sql->execute([
        "id" => $userid
    ]);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $sql2 = $db->prepare("SELECT * FROM ".PREFIX."users_blocked WHERE user_id = :id");
    $sql2->execute([
        "id" => $userid
    ]);
    $result2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $user){
        foreach ($result2 as $blocked){
            if($user['id'] == $blocked['blocked_id']){
                unset($result[array_search($user, $result)]);
            }
        }
    }
    $output = "";
    if(count($result) == 0){
        $output .= "Il n'y a pas d'utilisateurs existants pour discuter.";
    }elseif(count($result) > 0){
        include_once $_SERVER["DOCUMENT_ROOT"]."/wiews/chat/php/data.php";
    }
    echo $output;
?>