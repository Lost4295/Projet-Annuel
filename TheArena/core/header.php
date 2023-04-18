<!DOCTYPE html>
<html lang="fr" data-bs-theme="">
<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Arena</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/core/css/bootstrap.css">
    <link rel="stylesheet" href="/core/css/style.css">
    <link rel="icon" type="image/png" href="/img/logothearena-removebg.png" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col px-0">
            <nav class="navbar bar">
                <div class="container-fluid d-flex">
                        <div class="mr-auto">
                            <a class="navbar-brand" href="/">
                                <img src="/img/logothearena-removebg.png"
                                alt="Logo"
                                class="d-inline-block align-text-center logo">
                                <img src="/img/thearenatext-removebg.png"
                                alt="The Arena"
                                class="d-inline-block align-text-center textlogo">
                            </a>
                        </div>
                        <div>
                            <a class="btn btn-warning" href="connexion.php">Se connecter</a>
                            <a class="btn btn-warning" href="/wiews/register/inscription.php">S'inscrire</a>
<?php
// session_start();
// if($_POST){
// if (count($_POST) != 2
//     || empty($_POST["email"])
//     || empty($_POST["pwd"])
//     )
// {
//     die("Valeurs manquantes ou modifiées.");
// }
// $email=$_POST["email"];
// $password=$_POST["pwd"];

// function connectDB(){
//     //Connexion à la bdd (DSN, USER, PWD)
//     try{
//         $connection= new PDO("mysql:host=localhost;dbname=projet_web_1a4;port=3306","root","");
//     }catch (Exception $e){
//         die("Erreur SQL ".$e->getMessage());
//     }
// return $connection;
// }
// if (isset($email)){
//     $connection = connectDB();
//     $queryPrepared = $connection->prepare(" SELECT pwd FROM esgi_user WHERE email=:email");
//     $queryPrepared->execute([
//         "email"=>$email
//     ]);
//     $result=$queryPrepared->fetch();
//     if (!empty($result)){
//         if (password_verify($password,$result['pwd'])){
//             $_SESSION['email']=$email;
//             $_SESSION['login']=true;
//             header('Location:index.php');
//         } else {
//             $_SESSION["error"]="Erreur : mot de passe incorrect.";
//         }
//     } else {
//         $_SESSION["error"]="Erreur : mot de passe incorrect.";
//     }
//     }}
// <?php if(isset($_SESSION['error'])){
//             echo "<div class='alert alert-danger' role='alert'><ul>";
//             echo "<li>". $_SESSION['error'] . "</li>";
//             echo "</ul></div>";
//         }// On peut tout mettre à la suite, mais je trouve ça plus compréhensible
?>
<!-- <form method="post">
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
</div>
<div class="mb-3">
    <label for="pwd" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="pwd" name="pwd" required>
</div>
<div>
    <input type="submit" class="form-control btn btn-primary" value="Se connecter">
</div>
</form> -->
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div><!--notre sidebar-->
    <div class="container-fluid ">
    <div class="row">
        <div class="col-3 d-flex flex-wrap flex-column justify-content-around align-content-center bg-secondary">
            <div class="w-100 d-flex flex-column justify-content-between">
                <a href="/" class="my-3 w-100 btn btn-warning">Accueil</a>
                <a href="/wiews/events/evenements.php" class="my-3 w-100 btn btn-warning">Événements</a>
                <a href="/wiews/powerranking/powerRankingIndex.php" class="my-3 w-100 btn btn-warning">Power Ranking</a>
                <a href="/wiews/forum/forumindex.php" class="my-3 w-100 btn btn-warning">Forum</a>
            </div>
        <p>Pages récentes:</p>
        <div class="w-75 justify-content-center d-flex">
            <ul>
                <li>bla</li>
                <li>bla</li>
                <li>bli</li>
            </ul>
        </div>
    </div>
    <div class="col-9 my-3 py-4 d-flex align-content-center flex-column flex-wrap">
        <div class="w-100 mb-5">
