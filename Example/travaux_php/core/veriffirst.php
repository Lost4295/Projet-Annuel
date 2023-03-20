<?php 

//initialisation


if(file_exists('users.dat')){
    $tableau = unserialize(file_get_contents('users.dat'));
}
else {
    $tableau=array();
}


function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}

    
if ($_SERVER["REQUEST_METHOD"] == "POST") { //post
    if (empty($_POST["name"])) {
        $nameErr = "Le nom est requis.";
    }else{
        $name = test_input($_POST["name"]);}

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Le nom est requis.";
    } else {
        $lastname = test_input($_POST["lastname"]);
    }
    if (empty($_POST["login"])) {
        $loginErr = "Il faut un pseudonyme.";
    } else {
        $login = test_input($_POST["login"]);
    }if (empty($_POST["password"])) {
        $passwordErr = "Le mot de passe est requis.";
    } else{
        $password = hash("md5", test_input($_POST["password"]));
    }
    if (empty($_POST["gender"])) {
        $genderErr = "Erreur sur le genre.";
    } else{
        $gender = test_input($_POST["gender"]);
        
    }
    if (!preg_match("/^[a-zA-Z-]*$/",$name)) {
        $nameErr = "Merci de seulement utiliser des lettres.";
        $name ="";
    }
    if (!preg_match("/^[a-zA-Z-]*$/",$lastname)) {
        $lastnameErr = "Merci de seulement utiliser des lettres.";
        $lastname="";
    }
    if (!preg_match("/[a-zA-Z0-9]{4,}/",$login)) {
        $loginErr = "Insérez plus de 4 caractères alphanumériques.";
        $login="";
    } 
    if (!preg_match("/[a-zA-Z0-9]{8,}/",$password)) {
        $passwordErr = "Insérez plus de 8 caractères alphanumériques.";
        $password="";
    }
    if (!empty($name) && !empty($lastname) && !empty($login) && !empty($password) && !empty($gender)){
        if (array_key_exists($login, $tableau)) {
            $loginErr="Erreur : cet utilisateur existe déjà";
        }else { 
            
            $tableau[$login]= array('name'=> $name, 'lastname'=> $lastname, 'password'=> $password,'gender'=> $gender, 'rights' => 0);
            file_put_contents('users.dat', serialize($tableau));
            $_SESSION['login'] = $tableau[$login];
            $_SESSION['users'] = $login;
            header('Location: ../Page/Main/userpage.php');
            exit();
        }
    }
}    
?>