<?php
include_once 'functions.php';

$db = connectToDB();

$queryPrepared = $db->query("SELECT date, id FROM " . PREFIX . "tournaments");
$events = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

$timestamp_5min = time() - 60*5; // 60 * 5 = nombre de secondes écoulées en 5 minutes
$deleter = $db->prepare('DELETE FROM ' . PREFIX . 'connected_users WHERE timestamp < :timestamp_5min');
$deleter->execute(array('timestamp_5min' => date('yyyy-mm-dd H:i:s',$timestamp_5min)));
foreach ($events as $event) {
    if ($event['date'] < time()) {
        $queryPrepared = $db->prepare("UPDATE " . PREFIX . "events SET active = 0 WHERE id = :id");
        $queryPrepared->execute([
            ":id" => $event['id']
        ]);
    }
}
if (isConnected()) {

    $retour = $db->prepare('SELECT COUNT(*) AS nbre_entrees FROM ' . PREFIX . 'connected_users WHERE user_id =:id');
    $retour->execute(array('id' => $_SESSION['id']));
    $donnees = $retour->fetch();
    if ($donnees['nbre_entrees'] == 0) {
        $nquery = $db->prepare('INSERT INTO ' . PREFIX . 'connected_users (user_id) VALUES (:uid)');
        $nquery->execute([':uid' => $_SESSION['id']]);
    } else {
        $nquery2 = $db->prepare('UPDATE ' . PREFIX . 'connected_users SET v=:v WHERE user_id=:id');
        $nquery2->execute(array('v'=> rand(0, 520), 'id' => $_SESSION['id']));
    }
}
