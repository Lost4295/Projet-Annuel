<?php
require 'functions.php';
function generateActivationCode(): string
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
function deleteUserById($id)
{
    $db = connectToDB();
    $statement = $db->prepare('DELETE FROM users WHERE id =:id');
    return $statement->execute(['id'=> $id]);
}

function findUnverifiedUser(string $activationCode, string $email)
{

    $db = connectToDB();
    $queryPrepared = $db->prepare(
        'SELECT id, activation_timeout < now() as expired FROM users WHERE active = 0 AND email=:email'
    );
    $queryPrepared->execute([':email', $email]);

    $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            deleteUserById($user['id']);
            return null;
        }
        // verify the password
        if (password_verify($activationCode, $user['activationCode'])) {
            return $user;
        }
    }

    return null;
}

function activateUser($userId): bool
{
    $db = connectToDB();
    $query = $db->prepare('UPDATE users SET active = 1, activated_at = CURRENT_TIMESTAMP WHERE id=:id');
    return $query->execute(['id'=> $userId]);
}

