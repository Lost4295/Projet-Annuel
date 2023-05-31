<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'constantes.php';

function connectToDB()
{
    try {
        $db = new PDO('mysql:host=' . LOCALHOST . ';dbname=' . DBNAME . ';charset=utf8;port=3306', 'root', ''); // LOCAL
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
    }
    else{
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
    return ucwords(strtolower(trim($name)), "\t\r\n\f\v-'") ;
}




function generateRandCode(): string
{
    return bin2hex(random_bytes(2));
}
function unsetwhenRegistered()
{
    if (isset($_SESSION['errorfirstname'])) {
        unset($_SESSION['errorfirstname']);
    }
    if (isset($_SESSION['errorlastname'])) {
        unset($_SESSION['errorlastname']);
    }
    if (isset($_SESSION['errorbirthdate'])) {
        unset($_SESSION['errorbirthdate']);
    }
    if (isset($_SESSION['errorphonenumber'])) {
        unset($_SESSION['errorphonenumber']);
    }
    if (isset($_SESSION['erroraddress'])) {
        unset($_SESSION['erroraddress']);
    }
    if (isset($_SESSION['errorcp'])) {
        unset($_SESSION['errorcp']);
    }
    if (isset($_SESSION['errorcity'])) {
        unset($_SESSION['errorcity']);
    }
    if (isset($_SESSION['errorcountry'])) {
        unset($_SESSION['errorcountry']);
    }
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
    unsetwhenRegistered2();
}
function unsetwhenRegistered2()
{
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
    if (isset($_SESSION['errortype'])) {
        unset($_SESSION['errortype']);
    }
    if (isset($_SESSION['errorusername'])) {
        unset($_SESSION['errorusername']);
    }
    if (isset($_SESSION['erroremail'])) {
        unset($_SESSION['erroremail']);
    }
    if (isset($_SESSION['errorpwd'])) {
        unset($_SESSION['errorpwd']);
    }
    if (isset($_SESSION['errorpwdconfirm'])) {
        unset($_SESSION['errorpwdconfirm']);
    }
    if (isset($_SESSION['type'])) {
        unset($_SESSION['type']);
    }
    if (isset($_SESSION['pwd'])) {
        unset($_SESSION['pwd']);
    }
    if (isset($_SESSION['errornewsletter'])) {
        unset($_SESSION['errornewsletter']);
    }
    if (isset($_SESSION['errorcaptcha'])) {
        unset($_SESSION['errorcaptcha']);
    }
}

function unsetSessionErrors()
{
    if (isset($_SESSION['errorfirstname'])) {
        unset($_SESSION['errorfirstname']);
    }
    if (isset($_SESSION['errorlastname'])) {
        unset($_SESSION['errorlastname']);
    }
    if (isset($_SESSION['errorbirthdate'])) {
        unset($_SESSION['errorbirthdate']);
    }
    if (isset($_SESSION['errorphonenumber'])) {
        unset($_SESSION['errorphonenumber']);
    }
    if (isset($_SESSION['erroraddress'])) {
        unset($_SESSION['erroraddress']);
    }
    if (isset($_SESSION['errorcp'])) {
        unset($_SESSION['errorcp']);
    }
    if (isset($_SESSION['errorcity'])) {
        unset($_SESSION['errorcity']);
    }
    if (isset($_SESSION['errorcountry'])) {
        unset($_SESSION['errorcountry']);
    }
    if (isset($_SESSION['errorusername'])) {
        unset($_SESSION['errorusername']);
    }
    if (isset($_SESSION['erroremail'])) {
        unset($_SESSION['erroremail']);
    }
    if (isset($_SESSION['errorpwd'])) {
        unset($_SESSION['errorpwd']);
    }
    if (isset($_SESSION['errorpwdconfirm'])) {
        unset($_SESSION['errorpwdconfirm']);
    }
    if (isset($_SESSION['errornewsletter'])) {
        unset($_SESSION['errornewsletter']);
    }
    if (isset($_SESSION['errorcaptcha'])) {
        unset($_SESSION['errorcaptcha']);
    }
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['errortype'])) {
        unset($_SESSION['errortype']);
    }
    if (isset($_SESSION['errorabout'])) {
        unset($_SESSION['errorabout']);
    }
    if (isset($_SESSION['errorimage'])) {
        unset($_SESSION['errorimage']);
    }
    if (isset($_SESSION['errorabout'])) {
        unset($_SESSION['errorabout']);
    }
    if (isset($_SESSION['errorpwdconfirm'])) {
        unset($_SESSION['errorpwdconfirm']);
    }
}