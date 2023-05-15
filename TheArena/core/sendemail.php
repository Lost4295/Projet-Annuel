<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'constantes.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


//TODO : Déplacer la validation dans verrify 3

$activationCode = 'caca';
$subject='Validation du titre';
$email='snzonzi1@myges.fr';
$url = "http://thearena.litecloud.fr/core/auth.php?email=".$email."&activationCode=".$activationCode;
$body='Clique sur le lien pour valider le compte ! <a href='.$url.'> Cliquer</a><br><img src=cid:logo>';
function sendEmail($sender, $subject, $body)
{
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = SMTP; //Adresse IP ou DNS du serveur SMTP
$mail->Port = 465; //Port TCP du serveur SMTP
$mail->SMTPAuth = 1; //Utiliser l'identification
$mail->CharSet = 'UTF-8';

if ($mail->SMTPAuth) {
$mail->SMTPSecure = 'ssl'; //Protocole de sécurisation des échanges avec le SMTP
$mail->Username = NOREPLY; //Adresse email à utiliser
$mail->Password = MDP_NOREPLY; //Mot de passe de l'adresse email à utiliser
}

$mail->From = NOREPLY; //Adresse email de l'expéditeur
$mail->FromName = 'The Arena'; //Nom de l'expéditeur

$mail->AddAddress($sender); //Adresse email du destinataire

$mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'\img\logothearena-removebg.png', 'logo');
$mail->IsHTML(true); //Envoyer le message au format HTML
$mail->Subject = $subject; //Objet du message
$mail->Body = $body; //Corps du message au format HTML

if (!$mail->send()) {
    echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
} else {
    echo 'Le message a été envoyé.';
}
}

sendEmail($email, $subject, $body);


