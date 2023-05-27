<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';
$activationCode = generateActivationCode();
session_start();
$_SESSION['codes'] = $activationCode;
require $_SERVER['DOCUMENT_ROOT'] . '/core/sendmail.php';

function resetPassword()
{
    global $activationCode;
    global $email;
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $db = connectToDB();
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email AND phone=:phonenumber");
    $query->execute(['email' => $email, 'phonenumber' => $phonenumber]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['email'] = $email;
        $query = $db->prepare("UPDATE " . PREFIX . "users SET activation_code=:activationCode WHERE email=:email");
        $query->execute(['activationCode' => $activationCode, 'email' => $email]);
        sendEmail($email, 'Rénitialisation du mot de passe', 1);
    }
}
function enableAccount()
{
    $testemail = $_POST['email'];
    $db = connectToDB();
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
    $query->execute(['email' => $testemail]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
    global $activationCode;
        $email = $user['email'];
        $query = $db->prepare("UPDATE " . PREFIX . "users SET activation_code=:activationCode WHERE email=:email");
        $query->execute(['activationCode' => $activationCode, 'email' => $email]);
        $query2 = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
        $query2->execute(['email' => $email]);
        $result = $query2->fetch(PDO::FETCH_ASSOC);
        $_SESSION['email'] = $result['email'];
        print_r($_SESSION['email']);
        sendEmail($email, 'Activation du compte de ' . $user['username'] . ' The Arena', 0);
    }
}


header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        switch ($action) {
            case 'resetPassword':
                resetPassword();
                break;
            case 'enableAccount':
                enableAccount();
                break;
        }
    }

    echo json_encode(['success' => 'Email envoyé.']);
} else {
    echo json_encode(['error' => 'Méthode non autorisée.']);
}
