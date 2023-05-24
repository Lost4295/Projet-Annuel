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

<body onload="timeoutmod()">

    </div>
    <div class="container-fluid ps-0">
        <div class="row">
            <div class="col px-0">
                <nav class="navbar specbar">
                    <div class="container-fluid d-flex">
                        <div class="mr-auto">
                            <a class="navbar-brand" href="/">
                                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center logo">
                                <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center textlogo">
                            </a>
                        </div>
                        <a class="btn btn-warning" id="changeToDarkMode">theme</a>
                        <?php session_start();
                        include 'functions.php';
                        include 'formatter.php';
                        if (isConnected()) {
                            $attr = whoIsConnected();
                            if ($attr[0] == SUPADMIN || $attr[0] == ADMIN) { ?>
                                <div class="d-flex flex-row">
                                    <div class="mx-3"><a class="btn btn-warning " href="/admin">Index Admin</a></div>
                                <?php }
                            echo "Connecté en tant que " . $attr['1']; ?>
                                <div class="d-flex flex-row">
                                    <div class="mx-3"><a class="btn btn-warning " href="/logout">Se déconnecter</a></div>
                                    <div class="mx-2"><a class="btn btn-warning" href="/me">Ma page</a></div>
                                </div><?php } else { ?>
                                <div>
                                    <a class="btn btn-warning" href="/login">Se connecter</a>
                                    <a class="btn btn-warning" href="/register/1">S'inscrire</a>
                                </div>
                            <?php } ?>
                                </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="alert alert-<?php if (isset($_SESSION['message_type'])) {
                                    echo $_SESSION['message_type'];
                                } else {
                                    echo 'info';
                                } ?>"
                                id="alert"
                                style="display:<?php if (isset($_SESSION['message'])) {
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
        </div><!--notre sidebar-->
        <div class="container-fluid pl-0">
            <div class="row">
                    <div class="col-3 d-flex flex-wrap flex-column justify-content-around align-content-center bg-secondary">
                        <div class="w-100 d-flex flex-column justify-content-between">
                            <a href="/" class="my-3 w-100 btn btn-warning">Accueil</a>
                            <a href="/events" class="my-3 w-100 btn btn-warning">Événements</a>
                            <a href="/powerranking" class="my-3 w-100 btn btn-warning">Power Ranking</a>
                            <a href="/forums" class="my-3 w-100 btn btn-warning">Forum</a>
                        </div>
                        <p>Pages récentes:</p><?php //tableau here 
                                                ?>
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