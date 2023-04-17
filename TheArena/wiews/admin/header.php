<?php
  // session_start();
  // require "../../core/pdo.php";
  // $connection = connectToDB();
  // $_SESSION['email']=$email;
  // $_SESSION['login']=true;
  // $queryPrepared = $connection->prepare(" SELECT scope FROM zeya_users WHERE email=:email");
  // $queryPrepared->execute([
  //     "email"=>$email
  // ]);
  // $scope=$queryPrepared->fetch();
  // if($scope != 550620){
  //   header("location:indexSuperAdmin.php");
  // }
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="">
<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Arena</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col px-0">
                <nav class="navbar bar">
                    <div class="container-fluid d-flex">
                        <div class="mr-auto">
                            <a class="navbar-brand" href="/wiews">
                                <img src="../logothearena-removebg.png"
                                alt="Logo"
                                class="d-inline-block align-text-center logo">

                                <img src="../thearenatext-removebg.png"
                                alt="The Arena"
                                class="d-inline-block align-text-center textlogo">
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-3">
                <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height:86vh;">
                    <a
                        href="/"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                            <span class="fs-4">Page administration</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li>
                            <a href="indexadmin.php" class="nav-link aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                                Tableau de bord
                            </a>
                        </li>
                        <li>
                            <a href="notifications.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                                Notifications
                            </a>
                        </li>
                        <li>
                            <a href="signalements.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                                Sigalements
                            </a>
                        </li>
                        <li>
                            <a href="events.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                                Événements
                            </a>
                        </li>
                        <li>
                            <a href="users.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                                Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="forums.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                                Forums
                            </a>
                        </li>
                        <li>
                            <a href="settings.php" class="nav-link link-dark aaaa">
                                <svg class="bi me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                                Paramètres du site
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown">
                        <a
                            href="#"
                            class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                            id="dropdownUser2"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                                <img
                                    src="https://github.com/mdo.png"
                                    alt=""
                                    width="32"
                                    height="32"
                                    class="rounded-circle me-2">
                                <strong>mdo</strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-8">

