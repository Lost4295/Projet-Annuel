<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
session_start();
$db=connectToDB();
$query = $db->prepare("SELECT  ".PREFIX."user.id , ".PREFIX."user.score, ".PREFIX."user.country RANK() OVER (ORDER BY ".PREFIX."user.score DESC) AS globalRank  FROM (SELECT id, country, MAX(score) AS score 
    FROM".PREFIX."user WHERE id =200 GROUP BY id, country) AS classement");

$query->execute([
                ]);
$powerRankingClassement= $query->fetch();

