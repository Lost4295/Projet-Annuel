<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/events/finishevent.php";
session_start();
$db=connectToDB();
$query = $db->prepare("SELECT  ".PREFIX."powerranking.uid , ".PREFIX."powerranking.score, RANK() OVER (ORDER BY ".PREFIX."powerranking.score DESC) AS globalRank  FROM (SELECT id,  MAX(score) AS score 
    FROM".PREFIX."powerranking WHERE uid =200 and jeu = :jeu GROUP BY uid) AS classement");

$query->execute([
            "jeu"=> $event_game,
                ]);
$powerRankingClassement= $query->fetchAll(PDO::FETCH_ASSOC);


