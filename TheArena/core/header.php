<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="" style="height:100%">

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

<body onload="timeoutmod()" class="h-100">



    <nav class="navbar p-0 header">
        <div class="container-fluid d-flex justify-content-around">
            <div class="mr-auto">
                <a class="navbar-brand" href="/">
                    <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center logo">
                    <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center textlogo">
                </a>
            </div>

            <div>
                <form class="d-flex" role="search" method="get" action="/search">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" placeholder="Rechercher">
                        <button class="input-group-text" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="d-flex flex-row me-2">
                <div class="sun-moon mt-1 me-5">
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
                    <div class="dropdown mx-4">
                        <button onclick="myFunction()" class="btn btn-warning dropper"><img alt="Image de profil" id="avatar" src="<?php echo $attr[2] ?>" width="50px">&nbsp;<i id="triangle" class="bi bi-caret-down-fill"></i></button>
                        <div id="thedropdown" class="dropdown-content dropcolor">
                            <?php echo "Connecté en tant que " . $attr['1']; ?>
                            <a class="btn btn-warning" href="/me">Ma page</a>
                            <?php if ($attr[0] == SUPADMIN || $attr[0] == ADMIN) { ?>
                                <a class="btn btn-warning " href="/admin">Index Admin</a>
                            <?php } ?>
                            <a class="btn btn-danger " href="/logout"><i class="bi bi-box-arrow-right fs-4"></i> Se déconnecter </a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="d-flex align-items-center justify-content-between mx-4">
                        <a class="btn btn-warning mx-3" href="/login">Connexion</a>
                        <a class="btn btn-warning mx-3" href="/register">Inscription</a>
                    </div>
                <?php } ?>

            </div>
        </div>

    </nav>
    <div class="alert w-100 alert-<?php if (isset($_SESSION['message_type'])) {
                                        echo $_SESSION['message_type'];
                                    } else {
                                        echo 'info';
                                    } ?>" id="alert" style="display:<?php if (isset($_SESSION['message'])) {
                                                                echo "block; position:absolute; top:70px; right:0;";
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
        <div class="alert alert-<?php if (isset($_SESSION['notification_type'])) {
                                    echo $_SESSION['notification_type'];
                                } else {
                                    echo 'info';
                                } ?>" id="alert" style="display:<?php if (isset($_SESSION['notification'])) {
                                                                echo "block; position:absolute; top:70px; right:0;";
                                                            } else {
                                                                echo "none";
                                                            } ?>">
            <span class="closebtn" onclick="disappear();">&times;</span>
            <?php if (isset($_SESSION['notification'])) {
                echo $_SESSION['notification'];
                unset($_SESSION['notification']);
                unset($_SESSION['notification_type']);
            } ?>
        </div>
        </div><!--notre sidebar-->
        <div class="container-fluid pl-0" id="minheight">
            <div class="row" id="maxer">
                <div class="col-3 sidebar d-flex flex-wrap flex-column justify-content-around align-content-center bg-secondary">
                    <div class="w-100 d-flex flex-column justify-content-between">
                        <a href="/" class="my-3 w-100 btn btn-warning">Accueil</a>
                        <a href="/events" class="my-3 w-100 btn btn-warning">Événements</a>
                        <a href="/powerranking" class="my-3 w-100 btn btn-warning">Power Ranking</a>
                        <a href="/forums" class="my-3 w-100 btn btn-warning">Forum</a>
                    </div>
                    <p>Pages récentes:</p><?php //tableau here 
                                            ?>
                    <div class="w-75 justify-content-center d-flex">
                        <ul id="lastPages">
                        </ul>
                        <!-- <script>
                        let lastPages = document.getElementById("lastPages");
                        let one = document.createElement("li");
                        let a1 = document.createElement("a");
                        a1.setAttribute("onclick", "history.go(-1)");
                        a1.setAttribute("href", "#");
                        let two = document.createElement("li");
                        let a2 = document.createElement("a");
                        a2.setAttribute("onclick", "history.go(-2)");
                        a2.setAttribute("href", "#");
                        let three = document.createElement("li");
                        let a3 = document.createElement("a");
                        a3.setAttribute("onclick", "history.go(-3)");
                        a3.setAttribute("href", "#");
                        a1.innerHTML = "Page 1";
                        a2.innerHTML = "Page 2";
                        a3.innerHTML = "Page 3";
                        one.appendChild(a1);
                        two.appendChild(a2);
                        three.appendChild(a3);
                        lastPages.appendChild(one);
                        lastPages.appendChild(two);
                        lastPages.appendChild(three);
                    </script> -->
                    </div>
                </div>
                <div class=" content col-10 d-flex align-content-center flex-column flex-wrap">
                    <div class="w-100 mb-5">