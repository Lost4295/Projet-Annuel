<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
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
    <link rel="icon" type="image/png" href="img/logothearena-removebg.png" />
</head>

<body onload="timeoutmod()">

    </div>
    <div class="container-fluid ps-0">
        <div class="row">
            <div class="col px-0">
                <nav class="navbar specbar">
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="mr-auto">
                            <a class="navbar-brand" href="/">
                                <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center logo">
                                <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center textlogo">
                            </a>
                        </div>
                        <div class="sun-moon">
                            <input type="checkbox" id="changeToDarkMode" />
                            <span class="circle large"></span>
                            <span class="circle small"></span>
                        </div>
                        <?php
                        include_once 'functions.php';
                        include 'formatter.php';
                        if (isConnected()) {
                            $attr = whoIsConnected();
                        ?>
                            <div>
                                <form class="d-flex" role="search" method="get" action="/core/search.php">
                                    <div class="input-group mb-3">
                                        <input class="form-control" type="search" name="q" placeholder="Search">
                                        <button class="input-group-text" type="submit"><i class="bi bi-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="dropdown">
                                <button onclick="myFunction()" class="btn btn-warning dropper"><img alt="Image de profil" id="avatar" src="<?php echo $attr[2] ?>" width="50px">&nbsp;<i id="triangle" class="bi bi-caret-down-fill"></i></button>
                                <div id="thedropdown" class="dropdown-content dropcolor">
                                    <?php echo "Connecté en tant que " . $attr['1']; ?>
                                    <a class="btn btn-warning" href="/logout"><i class="bi bi-box-arrow-right text-danger fs-4"></i> Se déconnecter </a>
                                    <a class="btn btn-warning" href="/me">Ma page</a>
                                    <?php if ($attr[0] == SUPADMIN || $attr[0] == ADMIN) { ?>
                                        <a class="btn btn-warning " href="/admin">Index Admin</a>
                                    <?php } ?>
                                </div>
                            </div>


                        <?php } else { ?>
                            <div>
                                <a class="btn btn-warning" href="/login">Connexion</a>
                                <a class="btn btn-warning" href="/register">Inscription</a>
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
                        <a href="events" class="my-3 w-100 btn btn-warning">Événements</a>
                        <a href="powerranking" class="my-3 w-100 btn btn-warning">Power Ranking</a>
                        <a href="forums" class="my-3 w-100 btn btn-warning">Forum</a>
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