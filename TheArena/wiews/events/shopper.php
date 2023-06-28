<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
$db = connectToDB();
if (isset($_GET['event']) && !empty($_GET['event'])) {
    $name = strip_tags($_GET['event']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:name');
    $query->execute([':name' => $name]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if (!$event) {
        $_SESSION['message'] = "Cet évènement n'existe pas.";
        $_SESSION['message_type'] = "danger";
        header('Location: /');
    } else {
        $query2 = $db->prepare("INSERT INTO ". PREFIX. "shops (event) VALUES (:event)");
        $query2->execute([
            'event'=> $name
        ]);
        $query2 = $db->prepare("SELECT id FROM ".PREFIX."shops WHERE  event =:event");
        $query2->execute([
            'event'=> $name
        ]);
        $id = $query2->fetch(PDO::FETCH_ASSOC);
        $query4 = $db->prepare("UPDATE ".PREFIX."events SET shop_id =:id WHERE id=:eid");
        $query4->execute([
            'eid'=> $name,
            'id'=> $id['id']
        ]);
    }
    $_SESSION['message'] = "Le shop a bien été créé !";
    $_SESSION['message_type'] = "success";
    header('Location: /event_shop?shop='.$event['shop_id'].'&id='.$event['id']);
} else {
    $_SESSION['message'] = "Cet évènement n'existe pas.";
    $_SESSION['message_type'] = "danger";
    header('Location: /');
}

