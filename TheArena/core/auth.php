<?php

require 'loginfuncts.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // sanitize the email & activation code
    $inputs = filter_input_array(INPUT_GET, [
        'email' => FILTER_SANITIZE_EMAIL,
        'activationCode' => htmlspecialchars($_GET['activationCode'])
    ]);

    if ($inputs['email'] && $inputs['activationCode']) {
        $user = findUnverifiedUser($inputs['activationCode'], $inputs['email']);
        // if user exists and activate the user successfully
        if ($user && activateUser($user['id'])) {
            $_SESSION['message']='Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.';
        } else {
            $_SESSION['message']='La requête est invalide. Merci de réessayer.';
            $_SESSION['message_type']='danger';
            echo 'pas de user/ pas de activateUser';
        }
        }
    } else {// redirect to the register page in other cases
    $_SESSION['message']='La requête est invalide. Merci de réessayer.';
    $_SESSION['message_type']='danger';
    echo 'Pas de get';
}
die();
header("Location:/");



