<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$fmt = new IntlDateFormatter('fr_FR', IntlDateFormatter::NONE, IntlDateFormatter::NONE);
$fmt->setPattern('EEEE dd MMMM YYYY');
require 'constantes.php';

function connectToDB()
{
    try {
        $db = new PDO('mysql:host='.LOCALHOST.';dbname='.DBNAME.';charset=utf8;port=3306', DBUSER, DBPASSWORD); // VPS
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
function closeConnectionToDB($db)
{
    $db = null;
}

function isConnected()
{
    if (!empty($_SESSION["email"]) && (!empty($_SESSION["logged"]))) {
        $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT id FROM " . PREFIX . "users WHERE email=:email");
        $queryPrepared->execute(["email" => $_SESSION["email"]]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            return true;
        }
    }
    return false;
}

/*
 * @return array
 * scope, username, avatar
 */
function whoIsConnected()
{
    if (isConnected()) {
        $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT scope,username,avatar FROM " . PREFIX . "users WHERE email=:email");
        $queryPrepared->execute(["email" => $_SESSION["email"]]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            return [$result["scope"], $result["username"], $result["avatar"]];
        }
    } else {
        redirectifNotConnected();
    }
}

function redirectIfNotConnected()
{
    if (!isConnected()) {
        $_SESSION['message'] = "Vous n'êtes pas connecté. Cette page n'est pas accessible.";
        $_SESSION['message_type'] = "danger";
        header("Location: /login ");
    } else {
        return true;
    }
}
function onlyAdmin(): bool
{
    $scope = whoIsConnected()[0];
    return ($scope == ADMIN || $scope == SUPADMIN) ? true : false;
}

function redirectIfNotAdmin()
{
    if (!onlyAdmin()) {
        header("Location:/ ");
    }
}

function encodeImage($filename, $filetype)
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

function moveFile($path, $to)
{
    if (copy($path, $to)) {
        unlink($path);
        return true;
    } else {
        return false;
    }
}
function noReconnection()
{
    if (isConnected()) {
        $_SESSION['message'] = "Vous êtes déjà connecté. Cette page n'est pas accessible.";
        $_SESSION['message_type'] = "danger";
        header("Location:/ ");
    }
}
function base64EncodeImage($filename, $filetype)
{
    if ($filename) {
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}

function generateActivationCode(): string
{
    return bin2hex(random_bytes(16));
}

function cleanNames($name)
{
    return ucwords(strtolower(trim($name)), "\t\r\n\f\v-'");
}




function generateRandCode(): string
{
    return bin2hex(random_bytes(2));
}
function unsetwhenRegistered()
{
    unsetSessionErrors();
    if (isset($_SESSION['firstname'])) {
        unset($_SESSION['firstname']);
    }
    if (isset($_SESSION['lastname'])) {
        unset($_SESSION['lastname']);
    }
    if (isset($_SESSION['birthdate'])) {
        unset($_SESSION['birthdate']);
    }
    if (isset($_SESSION['phonenumber'])) {
        unset($_SESSION['phonenumber']);
    }
    if (isset($_SESSION['address'])) {
        unset($_SESSION['address']);
    }
    if (isset($_SESSION['cp'])) {
        unset($_SESSION['cp']);
    }
    if (isset($_SESSION['city'])) {
        unset($_SESSION['city']);
    }
    if (isset($_SESSION['country'])) {
        unset($_SESSION['country']);
    }
}

function unsetSessionErrors()
{
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'error') === 0) {
            unset($_SESSION[$key]);
        }
    }
}


function launchComeBack() {
 

    $db = connectToDB();
    $queryPrepared = $db->query("SELECT id, email, inactive_date FROM " . PREFIX . "users");
    $users = $queryPrepared->fetchAll();

$number = file_get_contents('number.php');
$number = (int) $number;

    foreach ($users as $user) {
        if ($user['inactive_date'] < time()) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/sendmail.php';

            include_once $_SERVER['DOCUMENT_ROOT'] . '/core/sendmail.php';

            sendEmail($user['email'], 'Vous ne jouez plus ?', 232, "<h2 style='width:50%;height:40px;padding-left:190px;text-align:right;margin:0px;color:#B24909;'>Vous ne revenez plus ?</h2><p>Bonjour, cela fait un moment que vous ne vous êtes pas connecté. Avez-vous abandonné The Arena ? <br>Ce serait dommage, car de nouveaux joueurs vous attendent ! Revenez vite auprès de nous, pour vous confronter à eux ! De nouveaux joueurs vous attendent ! <br> Organisez de nouveaux événements, et grimpez au sommet de la RankingList ! Nous vous attendons de tout coeur sur The Arena !</p>"); 
        }
    }
}