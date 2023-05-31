<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'functions.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$email = $_SESSION["emailtosend"];

$header= "<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='Ma duper super page' content='Page HTML'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Mail</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>
    <link rel='stylesheet' href='/core/css/bootstrap.css'>
    <link rel='stylesheet' href='/core/css/style.css'>
</head>
<body>
    <header>
        <div class='row'>
            <div class='col-3'>
                <img src='cid:logo'>
            </div>
            <div class='col center'>
                <img src='cid:text'>
            </div>

        </div>
    </header>";
    

    $bodync="<div class='div-container'>
        <div class='row'>
            <p>Bonjour pseudo,<br> Cet e-mail a été créé car une nouvelle connexion au compte pseudo a été établie le 19 septembre 2022 04:03:00 PDT (19 septembre 2022 11:03:00 UTC) depuis :<br>
            <li>
                <ul>Lieu : <br></ul>
                <ul>appareil : <br></ul>
                <ul>Navigateur : <br></ul>
                <ul>Adresse IP : <br></ul>
            </li></p>
        </div>

        <div class='row'>
            <a class='btn btn-warning' href='#'>Réinitialiser le mot de passe</a>
        </div>
        <div class='row'>
            <p>
                Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
            </p>
            <p>
                Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte.
            </p>
        </div>
    </div>";

    $bodyla="<div class='div-container'>
    <div class='row'>
        <p>Bonjour,<br> Nous avons reçu votre demande d'activation de compte. Utilisez le lien ci-dessous afin de pouvoir activer votre compte et pouvoir vous connecter au site.</p>
    </div>

    <div class='row'>
        <a class='btn btn-warning' href='#'>activation du compte</a>
    </div>
</div>";


$bodyw="<div class='div-container'>
        <div class='row'>
            <p>Bienvenue pseudo,<br></p>
            <p>Nous sommes ravis de vous présenter notre site dédié aux tournois et événements de jeux vidéo. 
Que vous soyez un joueur professionnel ou un amateur passionné, The Arena est l'endroit idéal pour vous inscrire à des tournois,<br>
 participer à des événements et être classé en fonction de vos performances. </p>
            <p>Notre site est facile à utiliser et vous permet de trouver rapidement des événements et des tournois qui correspondent à<br>
 vos intérêts et à votre niveau de compétence. De plus, notre système de classement vous permet de voir où vous vous situez par rapport aux autres joueurs
 et de suivre votre progression.</p>
            <p>Inscrivez-vous dès maintenant à un tournoi pour ne jamais manquer une opportunité de jouer, de vous améliorer et de vous classer parmi les meilleurs joueurs.</p>
        </div>
    </div>";


$urlv = "http://localhost:8000/authentification?email=".$email."&activationCode=".$activationCode;
$bodyv="<div class='div-container'>
    <div class='row'>
        <p>Bonjour,<br> Vous avez créé votre compte sur The Arena et nous vous en remercions. Cependant, vous ne pourrez pas vous connecter
sans que votre compte ait été vérifié. Veuillez cliquer sur le lien ci dessous pour pouvoir activer votre compte.</p>
    </div>
    <div class='row'>
        <a class='btn btn-warning' href=".$urlv.">Activer votre compte</a>
    </div>
    <div class='row'>
        <p>Vous avez reçu cet e-mail parce que vous avez demandé à activer votre compte pour vous connecter à votre compte The Arena.
Si vous n'avez pas demandé à vous connecter, ignorez cet e-mail.</p>
    </div>
</div>";


$urlfp="http://localhost:8000/resetPassword?activationCode=".$_SESSION["codes"]."&email=".$email;
    $bodyfp="<div class='div-container'>
        <div class='row'>
            <p>Bonjour,<br> Nous avons bien reçu votre demande de nouveau mot de passe. Afin de procéder à la création d’un nouveau mot de passe, nous vous invitons à cliquer sur le lien ci-dessous :</p>
        </div>

        <div class='row'>
            <a class='btn btn-warning' href='".$urlfp."'>réinitialiser le mot de passe</a>
        </div>
        <div class='row'>
            <p>Si vous n’êtes pas à l'origine de cette action,<br>veuillez contacter immédiatement notre centre de relation client au 01.23.45.67.89 (prix d'un appel local) <br> ou par mail à l'adresse suivante : postmaster@thearena.litecloud.com.</p>
        </div>
    </div>";

$footer="<footer>
        <div class='div-container'>
            <div class='row  center'>
                <p>Merci ! <br> L'équipe The Arena</p>
            </div>
            <div class='row '>
                <div class='col-6'>
                    <a href='thearena.litecloud.fr'> The Arena</a>
                </div>
                <div class='col-6'>
                    <a href='http://localhost:8000/noNewsletter?email=".$email."'> se désinscrire de la newsletter</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>";

/**
 * @param string $reciever
 * @param string $subject
 * @param int $type
 * @param string|null $body
 * Pour le type, il faut savoir que :
 * 0 = verification
 * 1 = forgotPwd
 * 2 = lockAccount
 * 3 = newConnection
 * 4 = welcome
 * 5 = newsletter
 * @return void
 */
function sendEmail(string $reciever, string $subject, int  $type, string $body = null)
{
    switch ($type) {
        case 0:
            global $bodyv;
            $mbody = $bodyv;
            break;
        case 1:
            global $bodyfp;
            $mbody = $bodyfp;
            break;
        case 2:
            global $bodyla;
            $mbody = $bodyla;
            break;
        case 3:
            global $bodync;
            $mbody = $bodync;
            break;
        case 4:
            global $bodyw;
            $mbody = $bodyw;
            break;
        case 5:
            global $bodyn;
            $mbody = $bodyn;
            break;
        default:
            $mbody = $body;
            break;
    }
    global $footer;
    global $header;
    $rbody = $header . $mbody . $footer;
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


    $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '\img\logothearena-removebg.png', 'logo');
    $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '/img/thearenatext-removebg.png', 'text');
    $mail->IsHTML(true); //Envoyer le message au format HTML
    $mail->Subject = $subject; //Objet du message
    $mail->Body = $rbody; //Corps du message au format HTML
    if (isset($_SESSION['codes'])) {
        unset($_SESSION["codes"]);
    }
    if (isset($_SESSION['emailtosend'])) {
        unset($_SESSION["emailtosend"]);
    }
    if (!$mail->send()) {
        echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
    } else {
        echo 'Le message a été envoyé.'; // for debbugging
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
    $mail->IsHTML(true); //Envoyer le message au format HTML
    $mail->Subject = 'Message provenant de la page de contacts'; //Objet du message
    $mail->Body = $body; //Corps du message au format HTML

    if (!$mail->send()) {
        echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
        die();
    } else {
        echo 'Le message a été envoyé.';
    }
}
