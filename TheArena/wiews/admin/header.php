<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';
include $_SERVER['DOCUMENT_ROOT'] . "/core/formatter.php";
redirectIfNotAdmin();
$who = whoIsConnected();
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Arena</title>
    <link rel="icon" type="image/png" href="/img/logothearena-removebg.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/core/css/bootstrap.css">
    <link rel="stylesheet" href="/core/css/style.css">
</head>

<body onload="timeoutmod()">
<div id="loading">
  <img id="loading-image" src="/img/loading-loading-forever.gif" alt="Loading..." />
</div>

    <div class="container-fluid">
        <div class="row">
            <div class="col px-0">
                <nav class="navbar bar">
                    <div class="container-fluid d-flex">
                        <div class="mr-auto">
                            <a class="navbar-brand" href="/">
                                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center logo">
                                <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center textlogo">
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="alert alert-<?php if (isset($_SESSION['message_type'])) {
                                    echo $_SESSION['message_type'];
                                } else {
                                    echo 'info';
                                } ?>" id="alert" style="display:<?php if (isset($_SESSION['message'])) {
                                                                                                                                                                    echo "block";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "none";
                                                                                                                                                                } ?>">
            <span class="closebtn" onclick="disappear();">&times;</span>
            <?php if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            } ?>
        </div>
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-3 sidebare p-0">
                    <div class="contented d-flex flex-column flex-shrink-0 p-3 bg-light">
                        <a href="/admin" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                            <svg class="bi me-2" width="40" height="32">
                                <use xlink:href="#bootstrap" />
                            </svg>
                            <span class="fs-4">Page administration</span>
                        </a>
                        <hr>
                        <ul class="nav nav-pills flex-column mb-auto">
                            <li>
                                <a href="/admin" id="dashboard" class="nav-link aaaa">
                                    Tableau de bord
                                </a>
                            </li>
                            <li>
                                <a href="/admin/signalements" id="reports" class="nav-link link-dark aaaa">
                                    Signalements
                                </a>
                            </li>
                            <li>
                                <a href="/admin/events" id="events" class="nav-link link-dark aaaa">
                                    Événements
                                </a>
                            </li>
                            <li>
                                <a href="/admin/users" id="users" class="nav-link link-dark aaaa">
                                    Utilisateurs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/forums" id="forums" class="nav-link link-dark aaaa">
                                    Forums
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/tournaments" id="tournaments" class="nav-link link-dark aaaa">
                                    Tournois
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/shops" id="shops" class="nav-link link-dark aaaa">
                                    Shops
                                </a>
                            </li>
                            <li>
                                <a href="/admin/settings" id="settings" class="nav-link link-dark aaaa">
                                    Paramètres du site
                                </a>
                            </li>
                            <li>
                                <a href="/" class="nav-link link-dark aaaa">
                                    Retour à la page d'accueil
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div>
                            <img src="<?php echo $who[2] ?>" alt="" width="32" height="32" class="rounded-circle me-2">
                                <strong><?php echo $who[1]?></strong>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    