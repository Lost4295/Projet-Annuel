<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';
noReconnection(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="Ma duper super page" content="Page HTML">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/logothearena-removebg.png" />
    <title>The Arena-Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/core/css/bootstrap.css">
    <link rel="stylesheet" href="/core/css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="mx-3 my-2">
                    <a class="navbar-brand" href="/">
                        <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center">
                        <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-3 d-flex flex-column mt-5 justify-content-between">
                <div>
                    <p id="text1"><i id="check1" class="bi bi-circle"></i>&emsp;&emsp;Informations relatives au site</p>
                </div>
                <div class="separation" id="bar1"></div>
                <div>
                    <p id="text2"><i id="check2" class="bi bi-circle"></i>&emsp;&emsp;Informations personnelles</p>
                </div>
                <div>
                    <div class="separation" id="bar2"></div>
                </div>
                <div>
                    <p id="text3"><i id="check3" class="bi bi-circle"></i>&emsp;&emsp;Confirmation</p>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <span id="errors" class="alert alert-danger"></span>
                    <div class="col pr-5 mr-5">
                        <form action="/core/verify3.php" method="post" id="allform">
                            <div id="form1">
                                <div class="row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="type" class="form-label">Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" value="1" id="player" checked>
                                            <label class="form-check-label" for="player">
                                                Joueur
                                            </label>
                                            <div class="form-check-inline form-check">
                                                <input class="form-check-input" type="radio" name="type" value="2" id="organizer">
                                                <label class="form-check-label" for="organizer">
                                                    Organisateur
                                                </label>
                                            </div>
                                            <span id="passwordHelpInline" class="form-text">
                                                Vous pourrez toujours ajouter, changer ou supprimer ce rôle plus tard.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="username" class="form-label">Nom d'utilisateur</label>
                                        <input type="text" name="username" class="form-control" id="username" required>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="john@doe.com" required>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="pwd" class="form-label">Mot de passe</label>
                                        <div class="input-group mb-3">
                                            <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required autocomplete="new-password">
                                            <button type="button" class="input-group-text" id="pwd-eye"><i class="bi bi-eye-slash-fill"></i></button>
                                        </div>
                                    </div>

                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="confirmpwd" class="form-label">Confirmation du mot de passe</label>
                                        <div class="input-group mb-3">
                                            <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required autocomplete="new-password">

                                            <button type="button" class="input-group-text" id="confpwd-eye"><i class="bi bi-eye-slash-fill"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form2">
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" required autocapitalize="words" placeholder="John">
                                    </div>
                                    <div class="col">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required autocapitalize="words" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="row mt-5 mb-3">
                                    <div class="col">
                                        <label for="birthdate" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" required placeholder="John">
                                    </div>
                                    <div class="col">
                                        <label for="phonenumber" class="form-label">Numéro de téléphone</label>
                                        <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required placeholder="0xxxxxxxxx">
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="adresse" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="adresse" name="fulladdress" required placeholder="1 Rue de Paris">
                                        <div id="selection" style="display: none;" class="dropdown-menu">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="resAdresse" hidden class="form-label">Adresse</label>
                                        <input type="text" hidden class="form-control" id="resAdresse" name="address" placeholder="France">
                                    </div>
                                    <div class="col">
                                        <label for="CP" hidden class="form-label">Code postal</label>
                                        <input type="text" hidden class="form-control" id="CP" name="cp" placeholder="75012">
                                    </div>
                                    <div class="col">
                                        <label for="Ville" hidden class="form-label">Ville</label>
                                        <input type="text" hidden class="form-control" id="Ville" name="city" placeholder="Paris">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div id="form3">
                        <div class="col">
                            <h1 class="text-center">Confirmation</h1>
                            <p>
                                Veuillez confirmer votre inscription en cochant les cases ci-dessous.
                            </p>
                        </div>
                        <div class="row mt-5 mb-5 pr-5">
                            <div class="row pr-5 mb-5" id="finalinfos">
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cgu" name="cgu" required>
                                    <label class="form-check-label" for="cgu">
                                        J'accepte les <a href="/cgu">CGU de The Arena</a>
                                    </label>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="newsletter" name="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            Je m'abonne à la newsletter
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5 mb-3 pr-5">
                                <label class="form-check-label">
                                    Vérifiez que vous n'êtes pas un robot, en reconstituant l'image ci-dessous.
                                </label>
                                <div class="col">
                                    <?php require $_SERVER['DOCUMENT_ROOT'] . '/core/createCaptcha.php' ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="drop-zone" id="dropZone1"></div>
                                    <div class="drop-zone" id="dropZone2"></div>
                                    <div class="drop-zone" id="dropZone3"></div>
                                </div>
                                <div class="row">
                                    <div class="drop-zone" id="dropZone4"></div>
                                    <div class="drop-zone" id="dropZone5"></div>
                                    <div class="drop-zone" id="dropZone6"></div>
                                </div>
                                <div class="row">
                                    <div class="drop-zone" id="dropZone7"></div>
                                    <div class="drop-zone" id="dropZone8"></div>
                                    <div class="drop-zone" id="dropZone9"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
                <div class="col-12">
                    <button type="button" id="continue" class="btn btn-primary">Continuer</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/wiews/register/inscription.js"></script>
</body>

</html>