<?php 
session_start();
file_get_contents('users.dat');
//initialisation
$login="";
$password="";
$loginErr="";
$passwordErr="";
if(!isset($tableau)){$tableau=array();}



if ($_SERVER["REQUEST_METHOD"] == "POST") { //post
    if (empty($_POST["login"])) {
        $loginErr = "Il faut un pseudonyme.";
    } else {
        $login = test_input($_POST["login"]);
    }if (empty($_POST["password"])) {
        $passwordErr = "Le mot de passe est requis.";
    } else{
        $password = test_input($_POST["password"]);
    }
    if (!preg_match("/[a-zA-Z0-9]{4,}/",$login)) {
        $loginErr = "Insérez plus de 4 caractères alphanumériques.";
        $login="";
    } 
    if (!preg_match("/[a-zA-Z0-9]{8,}/",$password)) {
        $passwordErr = "Insérez plus de 8 caractères alphanumériques.";
        $password="";
    }    
}

function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}
        
        
if (!empty($login) && !empty($password)){
    $tableau = unserialize(file_get_contents('users.dat'));
    if (array_key_exists($login, $tableau) && $tableau[$login]['password'] == hash("md5",$password)){
        $_SESSION['login'] = $tableau[$login];
        $_SESSION['users'] = $login;
        header('Location: userpage.php');
        exit();
    } else {
        $requis="Le nom d'utilisateur ou le mot de passe sont incorrects.";
    }   
}

        
?>
