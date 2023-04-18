<?php
function connectToDB():PDO
{
    try {
        $db = new PDO('54.36.180.242;dbname=pj_annuel;charset=utf8', 'websit', 'ConnardLV1');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
function isConnected()
{
    if (!empty($_SESSION["email"])&& (!empty($_SESSION["login"]))) {
        $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT id FROM esgi_user WHERE email=:email");
        $queryPrepared->execute(["email"=>$_SESSION["email"]]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            return true;
        }
    }
    return false;
}

function redirectIfNotConnected()
{
    if (!isConnected()) {
        header("Location: login.php");
    }
}
