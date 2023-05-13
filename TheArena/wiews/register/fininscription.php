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
                    </p>
                </div>
                <div>
                    <p>
                        <i class="bi bi-check-circle-fill text-info"></i>&emsp;&emsp;Informations personnelles
                    </p>
                </div>
                <div>
                    <p>
                        <i class="bi bi-circle"></i>&emsp;&emsp;Confirmation
                    </p>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col pr-5 mr-5">
                        <div class="row mt-5 mb-3 pr-5">
                            <div class="col">
                                <h1 class="text-center">Confirmation</h1>
                                <p>
                                    Veuillez confirmer votre inscription en cochant les cases ci-dessous.
                                </p>
                            </div>
                        </div>
                        <div class="row mt-5 mb-5 pr-5">
                            <div class="row pr-5 mb-5">
                                <div class="fs-3">Type</div>
                                <div><?php session_start(); echo $_SESSION['type']['nom']?></div>
                                <div class="fs-3">Nom d'utilisateur</div>
                                <div><?php echo $_SESSION['username']?></div>
                                <div class="fs-3">E-mail</div>
                                <div><?php echo $_SESSION['email']?></div>
                                <div class="fs-3">Nom</div>
                                <div><?php echo $_SESSION['lastname']?></div>
                                <div class="fs-3">Prénom</div>
                                <div><?php echo $_SESSION['firstname']?></div>
                                <div class="fs-3">Date de naissance</div>
                                <div><?php echo $_SESSION['birthdate']?></div>
                                <div class="fs-3">Numéro de téléphone</div>
                                <div><?php echo $_SESSION['phonenumber']?></div>
                                <div class="fs-3">Adresse</div>
                                <div><?php echo $_SESSION['address']?></div>
                            </div>
                            <form action="../../core/verify3.php" method="post">
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
                                    <div class="col">
                                        <img src="/wiews/register/captcha.php" width="100%">
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="captcha" placeholder="Captcha" required="required">
                                    <div class="invalid">
                                    <?php if (isset($_SESSION['errorcaptcha'])) { echo $_SESSION['errorcaptcha']; } ?>
                                </div>
                                </div>
                                <div class="col-12">
                                <button type="submit" class="btn btn-primary">Continuer</button>
                                    </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>