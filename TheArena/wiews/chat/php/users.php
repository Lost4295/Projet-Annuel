<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT']."/core/functions.php";

    redirectIfNotConnected();
    $user_id = $_SESSION['id'];
    $db = connectToDB();

    $sql = $db->prepare("SELECT id, username, avatar, activeonsite FROM ".PREFIX."users WHERE NOT id = :id AND id in (SELECT friend_id FROM zeya_user_friends WHERE user_id = :id) ORDER BY id DESC");
    $sql->execute([
        ":id" => $user_id
    ]);
    $friend_user_msg = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sql = $db->prepare("SELECT id, username, avatar, activeonsite FROM ".PREFIX."users WHERE NOT id = :id AND id in (SELECT user_id FROM zeya_messages WHERE reciever_id = :id) ORDER BY id DESC");
    $sql->execute([
        ":id" => $user_id
    ]);
    $other_user_msg = $sql->fetchAll(PDO::FETCH_ASSOC);

    $all_user_msg = $friend_user_msg + $other_user_msg;

    $sql = $db->prepare("SELECT blocked_id FROM ".PREFIX."users_blocked WHERE user_id = :id");
    $sql->execute([
        "id" => $user_id
    ]);
    $user_blocked = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach ($all_user_msg as $user) {
        foreach ($user_blocked as $blocked) {
            if($user['id'] == $blocked['blocked_id']) {
                unset($all_user_msg[array_search($user, $all_user_msg)]);
            }
        }
    }
    $output = "";
    if(count($all_user_msg) == 0){
        $output .= "Vous êtes bien silencieux actuellement ! Ajoutez des amis pour pouvoir discuter avec eux ou recherchez des utilisateurs !";
    }elseif(count($all_user_msg) > 0){
        include_once $_SERVER["DOCUMENT_ROOT"]."/wiews/chat/php/data.php";
    }
    echo $output;
?>