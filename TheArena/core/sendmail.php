<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'constantes.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'templateMail/headerMail.php';
require 'templateMail/footerMail.php';
require 'templateMail/verificationMail.php';
require 'templateMail/forgotPwdMail.php';
require 'templateMail/lockAccountMail.php';
require 'templateMail/newConnectionMail.php';
require 'templateMail/welcomeMail.php';
require 'templateMail/newsletterMail.php';


/**
 * @param string $reciever
 * @param string $subject
 * @param int $type
 * Pour le type, il faut savoir que :
 * 0 = verification
 * 1 = forgotPwd
 * 2 = lockAccount
 * 3 = newConnection
 * 4 = welcome
 * 5 = newsletter
 * @return void
 */
function sendEmail($reciever, $subject, $type, $infos=null)
    {
    switch ($type) {
        case 0:
            $body = $bodyv;
            break;
        case 1:
            $body = $bodyfp;
            break;
        case 2:
            $body = $bodyla;
            break;
        case 3:
            $body = $bodync;
            break;
        case 4:
            $body = $bodyw;
            break;
        case 5:
            $body = $bodyn;
            break;
        default:
            $body = $infos;
            break;
    }
    $rbody = $header . $body . $footer;
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
    
    $mail->AddAddress($reciever); //Adresse email du destinataire
    
    
    $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'\img\logothearena-removebg.png', 'logo');
    $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/img/thearenatext-removebg.png', 'text');
    $mail->IsHTML(true); //Envoyer le message au format HTML
    $mail->Subject = $subject; //Objet du message
    $mail->Body = $rbody; //Corps du message au format HTML
    
    if (!$mail->send()) {
        echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
    } else {
        echo 'Le message a été envoyé.';
    }
    }
    function sendEmailPostMaster($body)
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
        $mail->FromName = 'Contact'; //Nom de l'expéditeur
        
        $mail->AddAddress(POSTMASTER); //Adresse email du destinataire
        
        $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'\img\logothearena-removebg.png', 'logo');
        $mail->IsHTML(true); //Envoyer le message au format HTML
        $mail->Subject = 'Message provenant de la page de contacts'; //Objet du message
        $mail->Body = $body; //Corps du message au format HTML
        
        if (!$mail->send()) {
            echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
        } else {
            echo 'Le message a été envoyé.';
        }
    }

