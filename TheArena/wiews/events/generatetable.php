<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
function generatePairings($participants, $round_number)
{
    $pairings = array();
    $numParticipants = count($participants);
    // Tri des participants par score (ou tout autre critère)
    usort($participants, function ($a, $b) {
        return $b['score'] - $a['score'];
    });

    $groupSize = ceil($numParticipants / 2);
    $groupA = array_slice($participants, 0, $groupSize);
    $groupB = array_slice($participants, $groupSize);

    echo "Groupe A : <br>";
    echo '<pre>';
    print_r($groupA);
    echo '</pre>';
    echo "Groupe B : <br>";
    echo '<pre>';
    print_r($groupB);

    echo '</pre>';

    // Génération des appariements
    for ($i = 0; $i < $groupSize; $i++) {
        $pairings[] = array(
            'player1_id' => $groupA[$i]['user_id'],
            'player2_id' => $groupB[$i]['user_id'],
            'round_number' => $round_number
        );
    }

    return $pairings;
}
    $db = connectToDB();
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE event_id = :evet AND tournament_id = :tour'); 
    $participants = $queey->fetchAll(PDO::FETCH_ASSOC);
    // Génération des appariements pour la ronde actuelle
    $numParticipants = count($participants);
    if ($numParticipants % 2 == 1) {
        $inster = $db->prepare('INSERT INTO ' . PREFIX . 'events_users (event_id, user_id, tournament_id, ticket) VALUES (:event_id, :user_id, :tournament_id, :ticket)');
        $inster->execute([':event_id' => $_GET['eid'], ':user_id' => 1, ':tournament_id' => $_GET['id'], ':ticket' => 0]);
        $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE event_id = :evet AND tournament_id = :tour');
        $query->execute([':evet' => $_GET['eid'], ':tour' => $_GET['id']]);
        $participants = $query->fetchAll(PDO::FETCH_ASSOC);
        $numParticipants++;
    }

$numRounds = ceil(log($numParticipants, 2));
// Génération des rondes et des appariements
for ($roundNumber = 1; $roundNumber <= $numRounds; $roundNumber++) {
    $pairings = generatePairings($participants, $roundNumber);
        // Enregistrement des appariements dans la base de données
        foreach ($pairings as $pairing) {
            $player1_id = $pairing['player1_id'];
            $player2_id = $pairing['player2_id'];
            $round_number = $pairing['round_number'];

            // Requête SQL d'insertion pour insérer les valeurs des appariements dans la table "Matches"
            $sql = $db->prepare("INSERT INTO ".PREFIX."matches (round_number, player1_id, player2_id, player1_score, player2_score, tournament_id)
            VALUES (:round_number, :player1_id, :player2_id, NULL, NULL, :tournament_id)");

            $sql->execute(
                array(
                    'round_number' => $round_number,
                    'player1_id' => $player1_id,
                    'player2_id' => $player2_id,
                    'tournament_id' => $_GET['id']
                )
            );
        }
    }
