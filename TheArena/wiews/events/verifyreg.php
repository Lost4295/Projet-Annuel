<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';

if (
    count($_POST) != 5
    || empty($_POST["tournament"])
    || empty($_POST["paying"])
    || empty($_POST["cgu"])
    || empty($_POST["eventid"])
    || empty($_POST["eventname"])
) {
    print_r($_POST);
    die("Il ne vous est pas possible de terminer l'action. Merci de réessayer.
         Si cette page se réaffiche apèrs plusieurs essais, merci de vérifier vos informations,
         puis de contacter un administrateur.");
}

// $pseudo = $_POST["pseudo"];
$email = $_SESSION['email'];
$tournament = $_POST["tournament"];
$eventid = $_POST["eventid"];
$eventname = $_POST["eventname"];
$errorpseudo = "";
$errortournament = "";


$connection = connectToDB();
$queryPrepared = $connection->prepare("SELECT id,name FROM " . PREFIX . "events WHERE id=:id");
$queryPrepared->execute([
    'id' => $eventid
]);
$resulte = $queryPrepared->fetch(PDO::FETCH_ASSOC);

if (!isset($resulte)) {
    $error = true;
} else {
    $queryPrepared = $connection->prepare("SELECT id, username FROM " . PREFIX . "users WHERE email=:email");
    $queryPrepared->execute([
        'email' => $email
    ]);
    $resultp = $queryPrepared->fetch(PDO::FETCH_ASSOC);


    // if (strlen($pseudo) < 3) {
    //     $errorpseudo = "Votre pseudo doit contenir au moins 3 caractères.";
    // } elseif (strlen($pseudo) > 20) {
    //     $errorpseudo = "Votre pseudo ne peut pas contenir plus de 20 caractères.";
    // } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $pseudo)) {
    //     $errorpseudo = "Votre pseudo ne peut contenir que des lettres et des chiffres.";
    // } elseif (isset($resultp) && $pseudo == $resultp['username']) {
    //     $errorpseudo = "Ce pseudo est déjà utilisé. De toute façon, ceci n'était pas modifiable.";
    // } else {
    //     $errorpseudo = "";
    // }



    $query1 = $connection->prepare("SELECT id, name FROM " . PREFIX . "tournaments where event_id=:id");
    $query1->execute([
        'id' => $eventid
    ]);
    $possibletournaments = $query1->fetchAll(PDO::FETCH_COLUMN);

    $possibletournaments = array_flip($possibletournaments);

    foreach ($tournament as $key => $value) {
        if (!isset($possibletournaments[$key])) {
            $errortournament = "Un des tournois sélectionnés n'est pas valide.";
        } else {
            $keys[] = $key;
        }
    }


    if (/*empty($errorpseudo) &&*/ empty($errortournament)) {
        $error = false;
    } else {
        $error = true;
    }
}
if ($error) {
    $_SESSION['errorpseudo'] = $errorpseudo;
    $_SESSION['errortournament'] = $errortournament;
    header("Location:/event/register?name=" . $eventname . "");
} else {
    $emailer =$email;
    $body = "<h2 style='width:50%;height:40px;padding-left:120px;text-align:right;margin:0px;color:#B24909;'>Confirmation d'inscription</h2>
<p>Bonjour " . $pseudo . ",<br><br>Nous vous confirmons votre inscription";
    if (count($keys) > 1) {
        $body .= "aux tournois : ";
    } else {
        $body .= 'au tournoi : ';
    }
    $body .= "<br><br><ul>";
    foreach ($keys as $key) {
        $queryPrepared = $connection->prepare("SELECT id,name FROM " . PREFIX . "tournaments WHERE id=:id");
        $queryPrepared->execute([
            'id' => $key
        ]);
        $tournamentname = $queryPrepared->fetch(PDO::FETCH_ASSOC);

        $ticket = generateActivationCode();
        $queryPrepared = $connection->prepare("INSERT INTO " . PREFIX . "events_users (user_id, tournament_id, event_id, ticket) VALUES (:user_id, :tournament_id, :event_id,:ticket)");
        $queryPrepared->execute([
            'user_id' => $resultp['id'],
            'tournament_id' => $key,
            'event_id' => $eventid,
            'ticket' => $ticket
        ]);

        $body .= "<li>" . $tournamentname['name'] . " de l'évènement " . $resulte['name'] . ". Votre code de ticket est le suivant : " . $ticket . "</li>";
    }

    $body .= "</ul><br>Vous pouvez dès à présent vous rendre sur votre profil pour visualiser l'entièreté du tournoi.<br><br>
    Nous vous souhaitons une bonne journée, et surtout, de bien vous amuser lors de votre événement !<br><br></p>";
    include $_SERVER['DOCUMENT_ROOT'].'/core/sendmail.php';
    sendEmail($emailer, 'Confirmation d\'inscription', 18, $body);
    $_SESSION['message'] = "Vous avez bien été enregistré pour le tournoi. Un mail de confirmation vous a été envoyé !";
    $_SESSION['message_type'] = "success";
    header("Location: /events");
}
