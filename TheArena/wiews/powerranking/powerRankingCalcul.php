<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
session_start();
$db=connectToDB();
$query = $db->prepare("SELECT  ".PREFIX."powerranking.id , ".PREFIX."powerranking.score, ".PREFIX."powerranking.country RANK() OVER (ORDER BY ".PREFIX."powerranking.score DESC) AS globalRank  FROM (SELECT id,  MAX(score) AS score 
    FROM".PREFIX."powerranking WHERE id =200 GROUP BY id) AS classement");

$query->execute([
                ]);
$powerRankingClassement= $query->fetch();

