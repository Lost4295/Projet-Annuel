<?php
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
require $_SERVER['DOCUMENT_ROOT']."/core/formatter.php";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;




$html = '<html><body><img src="'.encodeImage($_SERVER['DOCUMENT_ROOT'].'/img/logothearena-removebg.png', 'png').'"/><img src="'.encodeImage($_SERVER['DOCUMENT_ROOT'].'/img/thearenatext-removebg.png', 'png').'"/>';

$db= connectToDB();
$queryPrepared = $db->prepare("SELECT * FROM ".PREFIX."users WHERE id = :id");
$queryPrepared->execute([
    "id" => $_SESSION['id']
]);
$user = $queryPrepared->fetch(PDO::FETCH_ASSOC);
$queryPrepared2 = $db->prepare("SELECT * FROM ".PREFIX."messages WHERE user_id = :id or reciever_id = :id");
$queryPrepared2->execute([
    "id" => $_SESSION['id']
]);
$messages = $queryPrepared2->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared3 = $db->prepare("SELECT * FROM ".PREFIX."forums WHERE author = :id");
$queryPrepared3->execute([
    "id" => $_SESSION['id']
]);
$forums = $queryPrepared3->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared4 = $db->prepare("SELECT * FROM ".PREFIX."forum_reponses WHERE user_id = :id");
$queryPrepared4->execute([
    "id" => $_SESSION['id']
]);
$forum_reponses = $queryPrepared4->fetchAll(PDO::FETCH_ASSOC);
$queryPrepared5 = $db->prepare("SELECT * FROM ".PREFIX."payments where user = :id");
$queryPrepared5->execute([
    "id" => $_SESSION['id']
]);
$payments = $queryPrepared5->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared6 = $db->prepare("SELECT * FROM ".PREFIX."users_likes where user_id = :id");
$queryPrepared6->execute([
    "id" => $_SESSION['id']
]);
$users_likes = $queryPrepared6->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared7 = $db->prepare("SELECT * FROM ".PREFIX."user_friends where user_id = :id AND accepted = 1");
$queryPrepared7->execute([
    "id" => $_SESSION['id']
]);
$users_friends = $queryPrepared7->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared8 = $db->prepare("SELECT * FROM ".PREFIX."users_blocked where user_id = :id");
$queryPrepared8->execute([
    "id" => $_SESSION['id']
]);
$users_blocked = $queryPrepared8->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared9 = $db->prepare("SELECT * FROM ".PREFIX."events where manager_id = :id");
$queryPrepared9->execute([
    "id" => $_SESSION['id']
]);
$events = $queryPrepared9->fetchAll(PDO::FETCH_ASSOC);

$queryPrepared10 = $db->prepare("SELECT * FROM ".PREFIX."events_users where user_id = :id");
$queryPrepared10->execute([
    "id" => $_SESSION['id']
]);
$events_users = $queryPrepared10->fetchAll(PDO::FETCH_ASSOC);


$html.='<br>Suite à votre demande de téléchargement de vos données personnelles, veuillez trouver ci-dessous les informations vous concernant :<br><br>';
$html.='<h2>Profil de '.$user['username'].'</h2>';
$html.='<p>Adresse mail : '.$user['email'].'</p>';
$html.='<p>Adresse : '.$user['address'].'</p>';
$html.='<p>Numéro de téléphone : '.$user['phone'].'</p>';
$html.='<p>Date de naissance : '.$user['birthdate'].'</p>';
$html.='<p>Avatar : <img src="'.$user['avatar'].'" style="margin-top:50px; width:100px; height:auto"/></p>';
$html.='<p>Créé le : '.$user['creation_date'].'</p>';
$html.='<p>Modifié la dernière fois le : '. $user['update_at'].'</p>';
$html.='<p>Statut : '.formatStatusUsers($user['status']).'</p>';
$html.='<p>Visibilité : '.formatVisibility($user['visibility']).'</p>';
$html.='<p>Scope : '.formatScope($user['scope']).'</p>';
$html.='<p>Rubrique à propos : ' .$user['about'].'</p>';

$html.='<h2>Statistiques de '.$user['username'].'</h2>';
$html.='<p>Nombre de messages envoyés : '.count($messages).'</p>';
$html.='<p>Nombre de forums créés : '.count($forums).'</p>';
$html.='<p>Nombre de messages envoyés sur les forums : '.count($forum_reponses).'</p>';
$html.='<p>Nombre de paiements effectués : '.count($payments).'</p>';
$html.='<p>Nombre d\'utilisateurs likés : '.count($users_likes).'</p>';
$html.='<p>Nombre d\'amis : '.count($users_friends).'</p>';


$html.='<h2>Messages de '.$user['username'].'</h2>';
if (empty($messages)){
    $html.='<p>Aucun message envoyé par '.$user['username'].'</p>';
}
foreach ($messages as $message){
    $html.='<p>Message de '.formatUsers($message['user_id']).' : " '.$message['content'].' " pour '.formatUsers($message['reciever_id']).'</p>';
}

$html.='<h2>Forums de '.$user['username'].'</h2>';
if (empty($forums)){
    $html.='<p>Aucun forum créé par '.$user['username'].'.</p>';
}
foreach ($forums as $forum){
    $html.='<p>Forum : '.$forum['title'].' créé le '.$forum['creation_date'].' par '.formatUsers($forum['author']).'</p>';
}

$html.='<h2>Messages de '.$user['username'].' envoyés sur les forums</h2>';
if (empty($forum_reponses)){
    $html.='<p>Aucun message envoyé par '.$user['username'].' sur les forums.</p>';
}
foreach ($forum_reponses as $forum_reponse){
    $html.='<p>Réponse : '.$forum_reponse['content'].' créé le '.$forum_reponse['creation_date'].' sur '.formatForumName($forum_reponse['forum_id']).'</p>';
}

$html.='<h2>Paiements de '.$user['username'].'</h2>';
if (empty($payments)){
    $html.='<p>Aucun paiement effectué par '.$user['username'].'.</p>';
}
foreach ($payments as $payment){
    $html.='<p>Paiement de '.formatProductsName($payment['product_id']).'coûtant '.findPriceByPID($payment['product_id']).' € effectué le '.$payment['date'].' pour </p>';
}

$html.='<h2>Utilisateurs likés par '.$user['username'].'</h2>';
if (empty($users_likes)){
    $html.='<p>Aucun utilisateur liké par '.$user['username'].'.</p>';
}
foreach ($users_likes as $user_like){
    $html.='<p>Utilisateur liké : '.formatUsers($user_like['liked_user_id']).' le '.$user_like['date'].'</p>';
}

$html.='<h2>Amis de '.$user['username'].'</h2>';
if (empty($users_friends)){
    $html.='<p>Aucun ami pour '.$user['username'].'.</p>';
}
foreach ($users_friends as $user_friend){
    $html.='<p>Ami : '.formatUsers($user_friend['friend_id']).' le '.$user_friend['date'].'</p>';
}

$html.='<h2>Utilisateurs bloqués par '.$user['username'].'</h2>';
if (empty($users_blocked)){
    $html.='<p>Aucun utilisateur bloqué par '.$user['username'].'.</p>';
}
foreach ($users_blocked as $user_blocked){
    $html.='<p>Utilisateur bloqué : '.formatUsers($user_blocked['blocked_id']).' le '.$user_blocked['date'].'</p>';
}

$html.='<h2>Evènements gérés par '.$user['username'].'</h2>';
if (empty($events)){
    $html.='<p>Aucun évènement géré par '.$user['username'].'.</p>';
}
foreach ($events as $event){
    $html.='<p>Evènement : '.$event['name'].' créé pour le jeu '.$event['game'].' : '.$event['description'].'</p>';
    $html.='<p>Image = <img src="'.$event['image'].'" style="margin-top:50px; width:100px; height:auto"/></p>';
}

$html.='<h2>Evènements auxquels '.$user['username'].' participe/ a participé</h2>';
if (empty($events_users)){
    $html.='<p>Aucun évènement auquel '.$user['username'].' participe/ a participé.</p>';
}

foreach ($events_users as $event_user){
    $html.='<p>Evènement : '.formatEventName($event_user['event_id']).' le '.$event_user['date'].' pour le tournoi '.formatTournamentName($event['tournament_id']).'<br>Id du ticket : '.$event['ticket'].'</p>';
}


$html.='</body></html>'; // Le contenu HTML à convertir en PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
header('Content-Type : application/pdf');
$dompdf->stream('fichier.pdf', ['Attachment' => false]);
