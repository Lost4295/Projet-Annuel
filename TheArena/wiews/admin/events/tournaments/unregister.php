

<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";

$db = connectToDB();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'tournaments WHERE `id`=:id');
    $query->execute([':id' => $id]);
    $tournament = $query->fetch();
    if (!$tournament) {
        header('Location: /admin/tournaments');
    }
} else {
    header('Location: /admin/tournaments');
}

if (isset($_GET['tid']) && !empty($_GET['tid'])) {
    $tid = strip_tags($_GET['tid']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE `user_id`=:id AND `tournament_id`=:tid');
    $query->execute([':id' => $id, ':tid' => $tid]);
    $user = $query->fetch();
    if (!$user) {
        header('Location: /admin/tournaments');
    }
} else {
    header('Location: /admin/tournaments');
}

if (isset($_GET) && !empty($_GET)) {
    $id = strip_tags($_GET['id']);
    $tid = strip_tags($_GET['tid']);
    $query = $db->prepare('DELETE FROM ' . PREFIX . 'events_users WHERE `user_id`=:id AND `tournament_id`=:tid');
    $query->execute([':id' => $id, ':tid' => $tid]);
    $_SESSION['message'] = formatUsers($id)." a bien été désinscrit du tournoi !";
    $_SESSION['message_type'] = "success";

    header('Location: /admin/tournament/read?id=' . $tid);
}