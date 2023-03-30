<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Arena-Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="mx-3 my-2">
                    <a class="navbar-brand" href="/">
                        <img src="logothearena-removebg.png" alt="Logo"  class="d-inline-block align-text-center">
                        <img src="thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-3 d-flex flex-column mt-5 justify-content-between">
                <div><p><i class="bi bi-circle"></i>&emsp;&emsp;Informations relatives au site</p></div> 
                <div><p><i class="bi bi-circle"></i>&emsp;&emsp;Informations personnelles</p></div> 
                <div><p><i class="bi bi-circle"></i>&emsp;&emsp;Confirmation</p></div> 
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col pr-5 mr-5">
                        <form action="../core/verify1.php" method="post">
                            <div class="row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <label for="type" class="form-label">Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" value="0" id="player" checked>
                                        <label class="form-check-label" for="player">
                                            Joueur
                                        </label>
                                        <div class="form-check-inline form-check">
                                            <input class="form-check-input" type="radio" name="type" value="1" id="organizer">
                                            <label class="form-check-label" for="organizer">
                                            Organisateur
                                            </label>
                                        </div>
                                        <span id="passwordHelpInline" class="form-text">
                                            Vous pourrez toujours ajouter, changer ou supprimer ce rôle plus tard.
                                        </span>
                                    </div>
                                </div>
                                <div class="invalid"> <?php session_start(); if(isset($_SESSION["errortype"]))echo $_SESSION['errortype'];?></div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <label for="username" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="username" class="form-control" id="username" required>
                                    <div class="invalid"> <?php if(isset($_SESSION["errorusername"]))echo $_SESSION['errorusername'];?></div>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="john@doe.com" required>
                                    <div class="invalid"> <?php if(isset($_SESSION["erroremail"]))echo $_SESSION['erroremail'];?></div>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
                                    <div class="invalid"> <?php if(isset($_SESSION["errorpwd"]))echo $_SESSION['errorpwd'];?></div>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <label for="confirmPwd" class="form-label">Confirmation du mot de passe</label>
                                    <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
                                    <div class="invalid"> <?php if(isset($_SESSION["errorpwdconfirm"]))echo $_SESSION['errorpwdconfirm'];?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Continuer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>