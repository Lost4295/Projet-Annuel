<?php
require 'functions.php';
function isUserActive($email)
{
    $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT id, status FROM ".PREFIX."users WHERE email=:email");
        $queryPrepared->execute(["email"=>$email]);
        $result = $queryPrepared->fetch();
        if ($result['status']==1) {
            return true;
        }
    return false;
}
function findUserByUsername(string $username)
{
    $db = connectToDB();
    $query = $db->prepare('SELECT username, password, status, email
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
        'SELECT id, activation_timeout < now() as expired,activation_code FROM '.PREFIX.'users WHERE status = 0 AND email=:email');
    $queryPrepared->execute([':email'=>$email]);
    $user = $queryPrepared->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if ((int)$user['expired'] === 1) {
            deleteUserById($user['id']);
            return null;
        }
        if ($activationCode==$user['activation_code']) {
            return $user;
        }
    }
    return null;
}

function activateUser($userId): bool
{
    $db = connectToDB();
    $query = $db->prepare('UPDATE '.PREFIX.'users SET status = 1, visibility = 2, activated_at = CURRENT_TIMESTAMP WHERE id=:id');
    return $query->execute(['id'=> $userId]);
}

