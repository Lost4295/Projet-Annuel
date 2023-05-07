<?php

require 'constantes.php';
function connectToDB()
{
    try {
        // $db = new PDO('mysql:host='.HOST.';dbname='.DBNAME.';charset=utf8;port=3306', DBUSER, DBPASSWORD);
        $db = new PDO('mysql:host='.LOCALHOST.';dbname='.DBNAME.';charset=utf8;port=3306', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $db;
}
function isConnected()
{
    if (!empty($_SESSION["email"]) && (!empty($_SESSION["logged"]))) {
        $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT id FROM ".PREFIX."users WHERE email=:email");
        $queryPrepared->execute(["email"=>$_SESSION["email"]]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            return true;
        }
    }
    return false;
}
function whoIsConnected() : array
{
    if (isConnected()) {
        $connect = connectToDB();
        $queryPrepared = $connect->prepare("SELECT scope,username FROM ".PREFIX."users WHERE email=:email");
        $queryPrepared->execute(["email"=>$_SESSION["email"]]);
        $result = $queryPrepared->fetch();
        if (!empty($result)) {
            return [$result["scope"],$result["username"]];
        }
    } else {
        redirectifNotConnected();
    }
}

function redirectIfNotConnected()
{
    if (!isConnected()) {
        header("Location:../wiews/register/login.php");
    }
}
function onlyAdmin():bool
{
    $scope =whoIsConnected()[0];
    print_r($scope);
    return ($scope == ADMIN || $scope == SUPADMIN)?true:false;
}

function redirectIfNotAdmin()
{
    if (!onlyAdmin()) {
        header("Location:/wiews/index.php");
    }
}
function noReconnection()
{
    if (isConnected()) {
        header("Location:/wiews/index.php");
    }
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
