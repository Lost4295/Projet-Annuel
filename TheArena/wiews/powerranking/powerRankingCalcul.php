<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
session_start();
$db=connectToDB();
$query = $db->prepare("SELECT  t.id , t.score, t.country RANK() OVER (ORDER BY t.score DESC) AS globalRank  FROM (SELECT id, country, MAX(score) AS score 
    FROM".PREFIX."user WHERE id =200 GROUP BY id, country) AS t");

$query->execute([
                ]);
$powerRankingClassement= $query->fetch();

