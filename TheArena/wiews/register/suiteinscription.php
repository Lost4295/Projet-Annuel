<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
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
                        <img src="/img/logothearena-removebg.png" alt="Logo"  class="d-inline-block align-text-center">
                        <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-3 d-flex flex-column mt-5 justify-content-between">
                <div>
                    <p>
                        <i class="bi bi-check-circle-fill text-info"></i>&emsp;&emsp;Informations relatives au site
                    <p>
                </div>
                <div><p><i class="bi bi-circle"></i>&emsp;&emsp;Informations personnelles<p></div>
                <div><p><i class="bi bi-circle"></i>&emsp;&emsp;Confirmation<p></div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col pr-5 mr-5">
                        <form action="/core/verify2.php" method="post">
                            <div class=" row mt-5 mb-3 pr-5" >
                                <div class="col">
                                    <label for="firstname" class="form-label">Prénom</label>
                                    <input
                                    type="text"
                                    class="form-control"
                                    id="firstname"
                                    name="firstname"
                                    required
                                    placeholder="John">
                                    <div class="invalid"><?php
                                        session_start();
                                        if (isset($_SESSION["errorfirstname"])) {echo $_SESSION['errorfirstname'];}
                                    ?></div>
                                </div>
                                <div class="col">
                                    <label for="lastname" class="form-label">Nom</label>
                                    <input type="text"
                                    class="form-control"
                                    id="lastname" name="lastname"
                                    required
                                    placeholder="Doe">
                                    <div class="invalid"><?php
                                        if (isset($_SESSION["errorlastname"])) {echo $_SESSION['errorlastname'];}
                                    ?></div>
                                </div>
                            </div>
                            <div class="row mt-5 mb-3">
                                <div class="col">
                                    <label for="birthdate" class="form-label">Date de naissance</label>
                                    <input type="date"
                                    class="form-control"
                                    id="birthdate"
                                    name="birthdate"
                                    required placeholder="John">
                                        <div class="invalid"> <?php
                                            if (isset($_SESSION["errorbirthdate"])) { echo $_SESSION['errorbirthdate'];}
                                            ?>
                                        </div>
                                </div>
                                <div class="col">
                                    <label for="phonenumber" class="form-label">Numéro de téléphone</label>
                                    <input
                                    type="tel"
                                    class="form-control"
                                    id="phonenumber"
                                    name="phonenumber"
                                    required
                                    placeholder="0xxxxxxxxx">
                                    <div class="invalid"> <?php
                                        if (isset($_SESSION["errorphonenumber"])) {echo $_SESSION['errorphonenumber'];}
                                    ?></div>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5" >
                                <div class="col">
                                    <label for="address" class="form-label">Adresse</label>
                                    <input type="text"
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    required
                                    placeholder="1 Rue de Paris">
                                    <div class="invalid"> <?php
                                        if (isset($_SESSION["erroraddress"])) {echo $_SESSION['erroraddress'];}
                                    ?></div>
                                </div>
                            </div>
                            <div class=" row mt-5 mb-3 pr-5" >
                                <div class="col">
                                    <label for="cp" class="form-label">Code postal</label>
                                    <input type="text"
                                    class="form-control"
                                    id="cp"
                                    name="cp"
                                    required
                                    placeholder="75012">
                                    <div class="invalid"> <?php
                                        if (isset($_SESSION["errorcp"])) {echo $_SESSION['errorcp'];}
                                    ?></div>
                                </div>
                                <div class="col">
                                    <label for="city" class="form-label">Ville</label>
                                    <input type="text"
                                    class="form-control"
                                    id="city"
                                    name="city"
                                    required
                                    placeholder="Paris">
                                    <div class="invalid"> <?php
                                        if (isset($_SESSION["errorcity"])) {echo $_SESSION['errorcity'];}
                                    ?></div>
                                </div>
                                <div class="col">
                                    <label for="country" class="form-label">Pays</label>
                                    <input type="text"
                                    class="form-control"
                                    id="country"
                                    name="country"
                                    required
                                    placeholder="France">
                                    <div class="invalid"> <?php
                                        if (isset($_SESSION["errorcountry"])) {echo $_SESSION['errorcountry'];}
                                    ?></div>
                            </div>
                            <div class="col-12 mt-2">
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
