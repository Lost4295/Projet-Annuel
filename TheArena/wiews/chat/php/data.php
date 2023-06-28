<?php

foreach ($result as $key => $user) {
    $queryPrepared = $db->prepare("SELECT * FROM " . PREFIX . "messages WHERE (reciever_id = :id1 OR user_id = :id1) AND (reciever_id = :id2 OR user_id = :id2) ORDER BY id DESC LIMIT 1");
    $queryPrepared->execute([
        "id1" => $user['id'],
        "id2"=> $userid
    ]);
    $result2 = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);
    (count($result2) > 0) ? $message = $result2[0]['content'] : $message = "Aucun message disponible.";
    (strlen($message) > 28) ? $msg =  substr($message, 0, 28) . '...' : $msg = $message;
    if (isset($result2[$key]['user_id'])) {
        ($userid == $result2[$key]['user_id']) ? $you = "Vous: " : $you = "";
    } else {
        $you = "";
    }
    ($user['activeonsite'] == "0") ? $offline = "offline" : $offline = "";
    ($userid == $user['id']) ? $hid_me = "hide" : $hid_me = "";

    $output .= '<a title="'.$user['username'].'" href="chat_chat?user_id=' . $user['id'] . '">
                    <div class="content">
                    <img src="' . $user['avatar'] . '" alt="">
                    <div class="details">
                        <span>' . $user['username'] . '</span>
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="bi bi-circle-fill"></i></div>
                </a>';
}
