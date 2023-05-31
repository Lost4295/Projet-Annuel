<?php

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

// sanitize the email & activation code
$inputs = filter_input_array(INPUT_GET, [
    'email' => FILTER_SANITIZE_EMAIL,
]);
if ($inputs['email']){
    $db = connectToDB();
    $query = $db->prepare('SELECT newsletter FROM '.PREFIX.'users WHERE email = :email');
    $query->execute([
        'email' => $inputs['email']
    ]);
    $result = $query->fetch();
    closeConnectionToDB($db);
    if ($result['newsletter'] == 0){
        $_SESSION['message']='Vous êtes déjà désinscrit de la newsletter.';
        $_SESSION['message_type']='danger';
    } else {
    $query = $db->prepare('UPDATE '.PREFIX.'users SET newsletter=0 WHERE email = :email');
    $query->execute([
        'email' => $inputs['email']
    ]);
    $_SESSION['message']='Vous avez été désinscrit de la newsletter avec succès.';
    $_SESSION['message_type']='success';
    
    }
} else {// redirect to the register page in other cases
    $_SESSION['message']='La requête est invalide. Merci de réessayer.';
    $_SESSION['message_type']='danger';
}
} else {
    $_SESSION['message']='La requête est invalide. Merci de réessayer.';
    $_SESSION['message_type']='danger';
}
header("Location: /");