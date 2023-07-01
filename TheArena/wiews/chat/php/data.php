<?php

foreach ($all_user_msg as $key => $user) {
    $sql = $db->prepare("SELECT content FROM " . PREFIX . "messages WHERE (reciever_id = :user_one OR user_id = :user_one) AND (reciever_id = :user_two OR user_id = :user_two) ORDER BY id DESC LIMIT 1");
    $sql->execute([
        "user_one" => $user['id'],
        "user_two"=> $user_id
    ]);
    $all_msg = $sql->fetchAll(PDO::FETCH_ASSOC);
    (count($all_msg) > 0) ? $message = $all_msg[0]['content'] : $message = "Aucun message disponible.";
    (strlen($message) > 28) ? $msg =  substr($message, 0, 28) . '...' : $msg = $message;
    if (isset($all_msg[$key]['user_id'])) {
        ($user_id == $all_msg[$key]['user_id']) ? $you = "Vous: " : $you = "";
    } else {
        $you = "";
    }
    ($user['activeonsite'] == "0") ? $offline = "offline" : $offline = "";
    ($user_id == $user['id']) ? $hid_me = "hide" : $hid_me = "";

    $output .= '<a title="'.$user['username'].'" href="/chat/chat?user_id=' . $user['id'] . '">
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
