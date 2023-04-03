<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/../core/PHPMailer/src/Exception.php';
require '/../core/PHPMailer/src/PHPMailer.php';
require '/../core/PHPMailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'ssl0.ovh.net'; //Adresse IP ou DNS du serveur SMTP
$mail->Port = 465; //Port TCP du serveur SMTP
$mail->SMTPAuth = 1; //Utiliser l'identification
$mail->CharSet = 'UTF-8';

if($mail->SMTPAuth){
$mail->SMTPSecure = 'ssl'; //Protocole de sécurisation des échanges avec le SMTP
$mail->Username = 'login@ovh.net'; //Adresse email à utiliser
$mail->Password = 'password'; //Mot de passe de l'adresse email à utiliser
}