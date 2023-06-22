<?php 
    session_start();
    if(isset($_SESSION['id'])){
        include_once $_SERVER["DOCUMENT_ROOT"]."/core/functions.php";
        $outgoing_id = $_SESSION['id'];
        $incoming_id = $_POST['incoming_id'];
        $message = $_POST['message'];
        if(!empty($message)){
            $db = connectToDB();
            $sql =$db->prepare( "INSERT INTO ".PREFIX."messages (reciever_id, user_id, content) VALUES (:reciever, :user, :message)");
        $sql->execute([
            'reciever' => $incoming_id,
            'user' => $outgoing_id,
            'message' => $message,
        ]);
        }
    }else{
        header("location: /chat");
    }


    
?>