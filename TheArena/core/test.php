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
//Ajo
    

$html.='</body></html>'; // Le contenu HTML à convertir en PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream('fichier.pdf', ['Attachment' => false]);
