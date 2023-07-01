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
    $queey = $db->query('SELECT * FROM ' . PREFIX . 'events_users WHERE event_id = 3'/*.$evenement['id']*/); // TODO ajouter les autres
    $participants = $queey->fetchAll(PDO::FETCH_ASSOC);
    // Génération des appariements pour la ronde actuelle
    $numParticipants = count($participants);

$numRounds = ceil(log($numParticipants, 2));
// Génération des rondes et des appariements
for ($roundNumber = 1; $roundNumber <= $numRounds; $roundNumber++) {
    $pairings = generatePairings($participants, $roundNumber);
    print_r($pairings);
        // Enregistrement des appariements dans la base de données
        foreach ($pairings as $pairing) {
            $player1_id = $pairing['player1_id'];
            $player2_id = $pairing['player2_id'];
            $round_number = $pairing['round_number'];

            print_r($player2_id);

            // Requête SQL d'insertion pour insérer les valeurs des appariements dans la table "Matches"
            $sql = $db->prepare("INSERT INTO ".PREFIX."matches (round_number, player1_id, player2_id, player1_score, player2_score)
            VALUES (:round_number, :player1_id, :player2_id, NULL, NULL)");

            $sql->execute(
                array(
                    'round_number' => $round_number,
                    'player1_id' => $player1_id,
                    'player2_id' => $player2_id
                )
            );
        }
    }
