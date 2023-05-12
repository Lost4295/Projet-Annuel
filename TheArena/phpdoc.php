<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/../core/PHPMailer/src/Exception.php';
require '/../core/PHPMailer/src/PHPMailer.php';
require '/../core/PHPMailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'vps-88c4c33d.vps.ovh.net'; //Adresse IP ou DNS du serveur SMTP
$mail->Port = 465; //Port TCP du serveur SMTP
$mail->SMTPAuth = 1; //Utiliser l'identification
$mail->CharSet = 'UTF-8';

if ($mail->SMTPAuth) {
$mail->SMTPSecure = 'ssl'; //Protocole de sécurisation des échanges avec le SMTP
$mail->Username = 'postmaster@thearena.litecloud.fr'; //Adresse email à utiliser
$mail->Password = 'pYZ@WmY^x#aobhPG&Ms@ekPND8vM5VAfmHn%hoEdoFZHqwz4WGKpPjJW2Kv3%AB^'; //Mot de passe de l'adresse email à utiliser
}

$mail->From = 'postmaster@thearena.litecloud.fr'; //Adresse email de l'expéditeur
$mail->FromName = 'The Arena'; //Nom de l'expéditeur

$mail->AddAddress(''); //Adresse email du destinataire

$mail->IsHTML(true); //Envoyer le message au format HTML
$mail->Subject = ''; //Objet du message
$mail->Body = ''; //Corps du message au format HTML
