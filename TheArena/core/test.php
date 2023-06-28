<?php
require $_SERVER['DOCUMENT_ROOT']."/core/functions.php";
require $_SERVER['DOCUMENT_ROOT']."/core/formatter.php";
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;



// TODO  FAIRE LE PDF


$html = '<html><body><img src="/img/placeholder_item.jpg"/><h1>The Arena</h1>';

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

$html.='<h2>Messages de '.$user['username'].'</h2>';
foreach ($messages as $message){
    $html.='<p>Message de '.formatUsers($message['user_id']).' : " '.$message['content'].' " pour '.formatUsers($message['reciever_id']).'</p>';
}

$html.='<h2>Forums de '.$user['username'].'</h2>';
foreach ($forums as $forum){
    $html.='<p>Forum : '.$forum['title'].' créé le '.$forum['creation_date'].' par '.formatUsers($forum['author']).'</p>';
}

$html.='<h2>Messages de '.$user['username'].' envoyés sur les forums</h2>';
foreach ($forum_reponses as $forum_reponse){
    $html.='<p>Réponse : '.$forum_reponse['content'].' créé le '.$forum_reponse['creation_date'].' sur '.formatForumName($forum_reponse['forum_id']).'</p>';
}


$html.='</body></html>'; // Le contenu HTML à convertir en PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('fichier.pdf', ['Attachment' => false]);
