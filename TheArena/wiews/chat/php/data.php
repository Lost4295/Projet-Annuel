<?php
    while($result){
        $queryPrepared = $db->prepare("SELECT * FROM ".PREFIX."messages WHERE (reciever_id = :id1 OR user_id = :id1) AND (user_id = :id2 OR reciever_id = :id2) ORDER BY id DESC LIMIT 1");
        $queryPrepared->execute([
            "id1" => $result['id'],
            "id2" => $reciever_id,
        ]);
        $result2 = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
        (count($result2) > 0) ? $result = $result2['msg'] : $result ="Aucun message disponible";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        if(isset($result2['user_id'])){
            ($reciever_id == $result2['user_id']) ? $you = "You: " : $you = "";
        }else{
            $you = "";
        }
        ($result['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        ($reciever_id == $result['id']) ? $hid_me = "hide" : $hid_me = "";

        $output .= '<a href="chat.php?user_id='. $result['id'] .'">
                    <div class="content">
                    <img src="php/images/'. $result['img'] .'" alt="">
                    <div class="details">
                        <span>'. $result['username'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';
    }
?>