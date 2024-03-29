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


$email = $_SESSION["emailtosend"]??null;

$header = "<!doctype html>
<html>
<head>
<title></title>
</head>
<body>
<span style='display:inline-block; max-height:0; max-width:0;mso-font-width:0%;mso-style-textfill-type: none; white-space: nowrap;'>
  <span style='max-height:1px; max-width:1px; display:inline-block; overflow:hidden; font-size:1px;color:rgba(0,0,0,0);text-indent:9px;'>
    Êtes-vous prêts à vous battre ?
  </span>
</span>
<div style='width:800px;background:#fff;border-style:groove;'>
<div style='width:50%;text-align:left;'><a href='https://thearena.litecloud.fr' alt='The Arena'> <img 
src=\"cid:logo\" height=60 width=60><img 
src=\"cid:text\" height=60 width=200></a></div>
<hr width='100%' size='2' color='#ccc'>";


$bodync = "<h2 style='width:50%;height:40px;padding-left:190px;text-align:right;margin:0px;color:#B24909;'>Rénitialisation du mot de passe</h2>
<p>Bonjour pseudo,<br> Cet e-mail a été créé car une nouvelle connexion au compte pseudo a été établie le 19 septembre 2022 04:03:00 PDT (19 septembre 2022 11:03:00 UTC) depuis :<br>
    <ul style='list-style:none'>
        <li>Lieu : <br></li>
        <li>appareil : <br></li>
        <li>Navigateur : <br></li>
        <li>Adresse IP : <br></li>
    </ul></p>        <p>
    Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
</p>
<p>
    Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte.
</p>";


$urlla = "http://localhost:8000/reactivation?email=" . $email . "&activationCode=" . $activationCode;
$bodyla = "<h2 style='width:50%;height:40px;padding-left:120px;text-align:right;margin:0px;color:#B24909;'>Activation du compte</h2>
    <p>Bonjour.<br> Nous avons reçu votre demande d'activation de compte. Utilisez le lien ci-dessous afin de pouvoir activer votre compte et pouvoir vous connecter au site.</p>
    
    <a style='padding-left:325px; color:orange;' href=" . $urlla . ">Activer votre compte</a>";

$a = connectToDB();
$sql = $a->prepare("SELECT username FROM " . PREFIX . "users WHERE email = '$email'");
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC);
$pseudo = $result["username"];


$bodyw = "<h2 style='width:50%;height:40px;padding-left:130px;text-align:right;margin:0px;color:#B24909;'>Bienvenue sur The Arena !</h2>
<p>Bienvenue $pseudo,<br>Nous sommes ravis de vous présenter notre site dédié aux tournois et événements de jeux vidéo.
Que vous soyez un joueur professionnel ou un amateur passionné, The Arena est l'endroit idéal pour vous inscrire à des tournois,<br>
participer à des événements et être classé en fonction de vos performances. </p>
    <p>Notre site est facile à utiliser et vous permet de trouver rapidement des événements et des tournois qui correspondent à<br>
vos intérêts et à votre niveau de compétence. De plus, notre système de classement vous permet de voir où vous vous situez par rapport aux autres joueurs
et de suivre votre progression.</p>
    <p>Inscrivez-vous dès maintenant à un tournoi pour ne jamais manquer une opportunité de jouer, de vous améliorer et de vous classer parmi les meilleurs joueurs.</p>    <hr />
    <div style='height:210px;'>
    <img style=' display: block;margin-left: auto;margin-right: auto;'
    src=\"cid:games\" height=100 width=200>";


$urlv = "http://localhost:8000/authentification?email=" . $email . "&activationCode=" . $activationCode;
$bodyv = "        <h2 style='width:50%;height:40px;padding-left:120px;text-align:right;margin:0px;color:#B24909;'>Vérification du compte</h2>
<p>Bonjour.<br> Vous avez créé votre compte sur The Arena et nous vous en remercions. Cependant, vous ne pourrez pas vous connecter
sans que votre compte ait été vérifié. Veuillez cliquer sur le lien ci dessous pour pouvoir activer votre compte.</p>
<a style='padding-left:325px; color:orange;' href=" . $urlv . ">Activer votre compte</a>";


$urlfp = "http://localhost:8000/resetPassword?activationCode=" . $_SESSION["codes"] . "&email=" . $email;
$bodyfp = "<h2 style='width:50%;height:40px;padding-left:190px;text-align:right;margin:0px;color:#B24909;'>Rénitialisation du mot de passe</h2>
<p>Bonjour,<br> Nous avons bien reçu votre demande de nouveau mot de passe. Afin de procéder à la création d’un nouveau mot de passe, nous vous invitons à cliquer sur le lien ci-dessous :</p>
<a style='padding-left:325px; color:orange;' href='" . $urlfp . "'>réinitialiser le mot de passe</a>
<p>Si vous n’êtes pas à l'origine de cette action, veuillez contacter immédiatement notre centre de relation client au <a href='tel:01.23.45.67.89'>01.23.45.67.89</a> (prix d'un appel local) ou par mail à l'adresse suivante : <a href='mailto:postmaster@thearena.litecloud.fr'>postmaster@thearena.litecloud.fr.</a></p>
";
function loginMail($email, $username)
{
    $fmt = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
    $fmt->setPattern('EEEE dd MMMM YYYY');
    $fmt2 = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.ip2location.io/?' . http_build_query([
        'ip'      => $_SERVER['REMOTE_USER'],
        'key'     => 'C8D8AFF498348B688B2A159636D5B7EE',
        'format'  => 'json',
    ]));

    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = json_decode(curl_exec($ch));

    function getBrowser()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Plateforme inconnue';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        } elseif (preg_match('/android/i', $u_agent)) {
            $platform = 'android';
        } elseif (preg_match('/iphone/i', $u_agent)) {
            $platform = 'iphone';
        } elseif (preg_match('/ipad/i', $u_agent)) {
            $platform = 'ipad';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif (preg_match('/Edge/i', $u_agent)) {
            $bname = 'Edge';
            $ub = "Edge";
        } elseif (preg_match('/Trident/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    }

    // now try it
    $ua = getBrowser();
    $body = "  <h2 style='width:50%;height:40px;padding-left:120px;text-align:right;margin:0px;color:#B24909;'>Nouvelle connexion détectée</h2>
<p>Bonjour $username,</br>
Cet e-mail a été créé car une nouvelle connexion au compte $username a été établie le " . $fmt->format($_SERVER['REQUEST_TIME']) . " depuis :<br>
•	Navigateur : " . $ua['name'] . " " . $ua['version'] . " sur " . $ua['platform'] . "<br>
•	Lieu :" . $response->city_name . ", " . $response->region_name . ", " . $response->country_name . " (" . $response->zip_code . ")<br>
•	Adresse IP : " . $_SERVER['REMOTE_ADDR'] . " <br>
•	Date : " .$fmt2->format($_SERVER['REQUEST_TIME']) . " <br>
Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte. <br>
";
    sendEmail($email, 'Nouvelle connexion détectée', 45455, $body);
}

$footer = "<hr />
        <p style='margin-top:8px'>Merci ! <br> L'équipe The Arena</p><div style='text-align:center;'><a href='http://localhost:8000'>The Arena</a></div>
        <p style='text-align:center; margin-top:0'>Vous ne voulez plus recevoir nos messages ? <a href='http://localhost:8000/noNewsletter?email=" . $email . "'>Faites le nous savoir.</a></p>
        </div>
    </div>
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
 * 2 = lockedAccount
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
    if ($type == 4) {
        $mail->addEmbeddedImage($_SERVER['DOCUMENT_ROOT'] . '/img/games.gif', 'games');
    }
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
