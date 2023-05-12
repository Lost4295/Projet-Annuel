<?php
require 'constantes.php';
require 'functions.php';
function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}
function isUserActive($email)
{
    $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT id, active FROM ".PREFIX."users WHERE email=:email");
        $queryPrepared->execute(["email"=>$email]);
        $result = $queryPrepared->fetch();
        if ($result['active']==1) {
            return true;
        }
    return false;
}
function findUserByUsername(string $username)
{
    $db = connectToDB();
    $query = $db->prepare('SELECT username, password, active, email
            FROM users
            WHERE username=:username');
    $query->execute([':username'=> $username]);
    return $query->fetch();
}


function sendActivationEmail(string $email, string $activationCode): void
{
    // create the activation link
    $activationLink = APP_URL . "/activate.php?email=".$email."&activation_code=".$activationCode;

    // set email subject & body
    $subject = 'Please activate your account';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activationLink
            MESSAGE;
    // email header
    $header = "From:" . EMAIL;

    // send the email
    mail($email, $subject, nl2br($message), $header);

}
function deleteUserById($id)
{
    $db = connectToDB();
    $statement = $db->prepare('DELETE FROM users WHERE id =:id');
    return $statement->execute(['id'=> $id]);
}
function removeUnverifiedUsers(string $email)
{
    $db = connectToDB();
    $queryPrepared = $db->prepare(
        'SELECT id, activation_expiry < now() as expired FROM users WHERE active = 0 AND email=:email'
    );
    $queryPrepared->execute([':email', $email]);

    $users = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    if ($users['expired'] === 1) {
        deleteUserById($users['id']);
        return null;
    }
}

function activateUser($userId): bool
{
    $db = connectToDB();
    $query = $db->prepare('UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP WHERE id=:id');
    return $query->execute(['id'=> $userId]);
}
