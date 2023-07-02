<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
$db = connectToDB();
$ql = $db->prepare("SELECT * FROM " . PREFIX . "matches WHERE `tournament_id`=:event_id");
$ql->execute([':event_id' => $_GET["id"]]);
$matches = $ql->fetchAll(PDO::FETCH_ASSOC);
// Récupération des résultats des matches et calcul des scores des joueurs
$scores = array();
foreach ($matches as $match) {
    $player1_id = $match['player1_id'];
    $player2_id = $match['player2_id'];
    $player1_score = $match['player1_score'];
    $player2_score = $match['player2_score'];
    
    // Calcul des scores des joueurs en fonction des résultats des matches
    if (!isset($scores[$player1_id])) {
        $scores[$player1_id] = 0;
    }
    if (!isset($scores[$player2_id])) {
        $scores[$player2_id] = 0;
    }
    
    // Ajout des scores des joueurs en fonction des résultats des matches
    $scores[$player1_id] += $player1_score;
    $scores[$player2_id] += $player2_score;
}

// Tri des scores des joueurs dans l'ordre décroissant
arsort($scores);

// Classement des joueurs
$rankings = array();
$rank = 1;
foreach ($scores as $player_id => $score) {
    $rankings[] = array(
        'player_id' => $player_id,
        'rank' => $rank,
        'score' => $score
    );
    $rank++;
}


$gfr = $db->prepare("SELECT a FROM " . PREFIX . "events WHERE `id`=:event_id");

// Affichage des classements des joueurs
foreach ($rankings as $ranking) {
    $player_id = $ranking['player_id'];
    $rank = $ranking['rank'];
    $score = $ranking['score'];

}


