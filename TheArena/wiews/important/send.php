<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';


if (
    count($_POST) != 5
    || !isset($_POST['lastname'])
    || !isset($_POST['firstname'])
    || !isset($_POST['email'])
    || !isset($_POST['type'])
    || !isset($_POST['message'])
) {
    echo "Erreur de formulaire <br>";
    print_r($_POST);
    die();
}

$lastname = cleanNames($_POST['lastname']);
$firstname = cleanNames($_POST['firstname']);
$email = strtolower(trim($_POST['email']));
$type = $_POST['type'];
$message = $_POST['message'];

$types = [1, 2, 3, 4];

if (!in_array($type, $types)) {
    $errortype = "Ce rôle n'existe pas.";
} else {
    switch ($type) {
        case 2:
            $type = "Réclamation";
            break;
        case 3:
            $type = "Effacer les données";
            break;
        case 4:
            $type = "Autre";
            break;
        case 1:
        default:
            $type = "Assistance";
            break;
    }
}

if (strlen($lastname) < 2) {
    $errorlastname = "Le nom doit faire plus de 2 caractères.";
}

if (strlen($firstname) < 2) {
    $errorfirstname = "Le prénom doit faire plus de 2 caractères.";
}

if (strlen($lastname) > 70) {
    $errorlastname = "Le nom doit faire moins de 70 caractères.";
}

if (strlen($firstname) > 50) {
    $errorfirstname = "Le prénom doit faire moins de 50 caractères.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erroremail = "L'email est incorrect.";
} else {
    $_SESSION["emailtosend"] = $email;
}

if (strlen($message) < 10) {
    $errormessage = "Le message doit faire plus de 10 caractères.";
}
if (strlen($message) > 500) {
    $errormessage = "Le message doit faire moins de 500 caractères.";
}

if (
    isset($errortype)
    || isset($errorlastname)
    || isset($errorfirstname)
    || isset($erroremail)
    || isset($errormessage)
) {
    $_SESSION["errorlastname"] = $errorlastname ?? "";
    $_SESSION["errorfirstname"] = $errorfirstname ?? "";
    $_SESSION["erroremail"] = $erroremail ?? "";
    $_SESSION["errortype"] = $errortype ?? "";
    $_SESSION["errormessage"] = $errormessage ?? "";
    header("Location: /contact");
} else {
    include $_SERVER['DOCUMENT_ROOT'].'/core/sendmail.php';
    $body = "Bonjour " . $firstname . " " . $lastname . ".<br> Le type du message que vous venez d'envoyer est : " . $type . "<br> Voici le contenu du message : <br><br>" . $message . "<br><br> Ce message a été envoyé afin de pouvoir accuser réception de votre message de contact. Nous allons traiter votre demande au plus vite. <br> Nous vous remercions de votre confiance. <br>";
    sendEmail($email, 'Récapitulatif du message envoyé', 6, $body);
    $bodypm = "Bonjour, <br> Un nouveau message a été envoyé par " . $firstname . " " . $lastname . ".<br> Son email est : " . $email . "<br> Le type du message est : " . $type . "<br> Voici le contenu du message : <br><br>" . $message . "<br><br> ";
    sendEmailPostMaster($bodypm);
    $_SESSION["message"] = "Votre message a bien été envoyé !";
    $_SESSION['message_type'] = "success";
    header("Location: /");
}
