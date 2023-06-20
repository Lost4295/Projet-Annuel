<?php
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
    $outgoing_id = $_SESSION['id'];
    $db = connectToDB();
    $sql = $db->prepare("SELECT * FROM ".PREFIX."users WHERE NOT id = :id ORDER BY id DESC");
    $sql->execute([
        "id" => $outgoing_id
    ]);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    if(count($result) == 0){
        $output .= "No users are available to chat";
    }elseif(count($result) > 0){
        include_once $_SERVER["DOCUMENT_ROOT"]."/wiews/chat/php/data.php";
    }
    echo $output;
?>