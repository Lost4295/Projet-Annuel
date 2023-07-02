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
    for ($i = 0; $i < $numParticipants - 1; $i++) {
        for ($j = $i + 1; $j < $numParticipants; $j++) {
            $pairings[] = array(
                'player1_id' => $participants[$i]['user_id'],
                'player2_id' => $participants[$j]['user_id'],
                'round_number' => $round_number
            );
        }
    }


    return $pairings;
}

if (isset($_GET['id']) && isset($_GET['eid']) && isset($_SESSION['id'])) {
    $db = connectToDB();
    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events WHERE id = :id');
    $query->execute([':id' => $_GET['eid']]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    if ($event['manager_id'] != $_SESSION['id']) {
        header('Location: /');
        $_SESSION['message'] = "Une erreur est survenue.";
        $_SESSION['message_type'] = "danger";
        exit();
    }
    $verif = $db->prepare('SELECT * FROM ' . PREFIX . 'matches WHERE tournament_id = :id');
    $verif->execute([':id' => $_GET['id']]);
    $verif = $verif->fetchAll(PDO::FETCH_ASSOC);
    if (count($verif) > 0) {
        header('Location: /event/management?id=' . $_GET['eid']);
        $_SESSION['message'] = "Les appariements ont déjà été générés pour ce tournoi.";
        $_SESSION['message_type'] = "danger";
        exit();
    }

    $query = $db->prepare('SELECT * FROM ' . PREFIX . 'events_users WHERE event_id = :evet AND tournament_id = :tour');
    $query->execute([':evet' => $_GET['eid'], ':tour' => $_GET['id']]);
    $participants = $query->fetchAll(PDO::FETCH_ASSOC);
    // Génération des appariements pour la ronde actuelle
    $numParticipants = count($participants);


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
            $sql = $db->prepare("INSERT INTO " . PREFIX . "matches (round_number, player1_id, player2_id, player1_score, player2_score, tournament_id)
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
    header('Location: /event/management?id=' . $_GET['eid']);
    $_SESSION['message'] = "Les appariements ont été générés.";
    $_SESSION['message_type'] = "success";
    exit();
} else {
    header('Location: /');
    $_SESSION['message'] = "Une erreur est survenue.";
    $_SESSION['message_type'] = "danger";
    exit();
}
