<?php
include_once 'functions.php';

$db = connectToDB();

$queryPrepared = $db->query("SELECT date, id FROM " . PREFIX . "tournaments");
$events = $queryPrepared->fetchAll(PDO::FETCH_ASSOC);

foreach ($events as $event) {
    if ($event['date'] < time()) {
        $queryPrepared = $db->prepare("UPDATE " . PREFIX . "events SET active = 0 WHERE id = :id");
        $queryPrepared->execute([
            ":id" => $event['id']
        ]);
    }
}