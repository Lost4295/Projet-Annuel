<?php

require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
$db = connectToDB();
    $eventid = strip_tags($_GET['eventid']);
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE `id`=:eventid');
    $query->execute([':eventid' => $eventid]);
    $evenement = $query->fetch(PDO::FETCH_ASSOC);
    $nquery =  $db->prepare('SELECT * FROM ' . PREFIX . 'users WHERE `id`=:id');
    $nquery->execute([':id' => $_SESSION['id']]);
    $user = $nquery->fetch(PDO::FETCH_ASSOC);


if (isConnected() && ($user['id'] == $evenement['manager_id'])) {
    $player1_id = strip_tags($_GET['player1id']);
    $player2_id = strip_tags($_GET['player2id']);
    $event_id = strip_tags($_GET['eventid']);
    $match_id = strip_tags($_GET['match_id']);
    $player1_score = strip_tags($_GET['player1_score'.$match_id]);
    $player2_score = strip_tags($_GET['player2_score'.$match_id]);

    $sql = $db->prepare('UPDATE ' . PREFIX . 'matches SET `player1_score`=:player1_score, `player2_score`=:player2_score WHERE `player1_id`=:player1_id AND `player2_id`=:player2_id AND `match_id`=:match_id');
    $sql->execute([':player1_score' => $player1_score, ':player2_score' => $player2_score, ':player1_id' => $player1_id, ':player2_id' => $player2_id, ':match_id' => $match_id]);
}

header('Location: /event/management?id='.$eventid);