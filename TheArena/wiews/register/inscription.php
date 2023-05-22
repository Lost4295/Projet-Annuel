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
                        <img src="/img/logothearena-removebg.png" alt="Logo" class="d-inline-block align-text-center">
                        <img src="/img/thearenatext-removebg.png" alt="The Arena" class="d-inline-block align-text-center">
                    </a>
                </div>
            </div>
        </div>
        <div class="row mr-5 mt-3">
            <div class="col-3 d-flex flex-column mt-5 justify-content-between">
                <div>
                    <p><i id="check1" class="bi bi-circle"></i>&emsp;&emsp;Informations relatives au site</p>
                </div>
                <div>
                    <p><i id="check2" class="bi bi-circle"></i>&emsp;&emsp;Informations personnelles</p>
                </div>
                <div>
                    <p><i id="check3" class="bi bi-circle"></i>&emsp;&emsp;Confirmation</p>
                </div>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col pr-5 mr-5">
                        <span id="errors"></span>
                        <form action="/core/verify1.php" method="post">
                            <div id="form1">
                                <div class="row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="type" class="form-label">Type</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" value="0"
                                                id="player" checked>
                                            <label class="form-check-label" for="player">
                                                Joueur
                                            </label>
                                            <div class="form-check-inline form-check">
                                                <input class="form-check-input" type="radio" name="type" value="1"
                                                    id="organizer">
                                                <label class="form-check-label" for="organizer">
                                                    Organisateur
                                                </label>
                                            </div>
                                            <span id="passwordHelpInline" class="form-text">
                                                Vous pourrez toujours ajouter, changer ou supprimer ce rôle plus tard.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="invalidtype">
                                        <?php session_start(); if (isset($_SESSION["errortype"])) {
                                            echo $_SESSION['errortype'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="username" class="form-label">Nom d'utilisateur</label>
                                        <input type="text" name="username" class="form-control" id="username" required>
                                        <div class="invalidusername">
                                            <?php if (isset($_SESSION["errorusername"])) {
                                                echo $_SESSION['errorusername'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="john@doe.com" required>
                                        <div class="invalidemail">
                                            <?php if (isset($_SESSION["erroremail"])) {
                                                echo $_SESSION['erroremail'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" name="pwd" class="form-control" id="pwd"
                                            placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)"
                                            required>
                                        <div class="invalidpwd">
                                            <?php if (isset($_SESSION["errorpwd"])) {
                                                echo $_SESSION['errorpwd'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="confirmPwd" class="form-label">Confirmation du mot de passe</label>
                                        <input type="password" name="confirmpwd" class="form-control" id="confirmpwd"
                                            placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)"
                                            required>
                                        <div class="invalidpwdconfirm">
                                            <?php if (isset($_SESSION["errorpwdconfirm"])) {
                                                echo $_SESSION['errorpwdconfirm'];
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="form2">
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            required placeholder="John">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorfirstname"])) {echo $_SESSION['errorfirstname'];}
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            required placeholder="Doe">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorlastname"])) {echo $_SESSION['errorlastname'];}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 mb-3">
                                    <div class="col">
                                        <label for="birthdate" class="form-label">Date de naissance</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate"
                                            required placeholder="John">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorbirthdate"])) { echo $_SESSION['errorbirthdate'];}
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="phonenumber" class="form-label">Numéro de téléphone</label>
                                        <input type="tel" class="form-control" id="phonenumber" name="phonenumber"
                                            required placeholder="0xxxxxxxxx">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorphonenumber"])) {echo $_SESSION['errorphonenumber'];}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="address" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" required
                                            placeholder="1 Rue de Paris">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["erroraddress"])) {echo $_SESSION['erroraddress'];}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="cp" class="form-label">Code postal</label>
                                        <input type="text" class="form-control" id="cp" name="cp" required
                                            placeholder="75012">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorcp"])) {echo $_SESSION['errorcp'];}
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="city" class="form-label">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" required
                                            placeholder="Paris">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorcity"])) {echo $_SESSION['errorcity'];}
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label for="country" class="form-label">Pays</label>
                                        <input type="text" class="form-control" id="country" name="country" required
                                            placeholder="France">
                                        <div class="invalid">
                                            <?php
                                                if (isset($_SESSION["errorcountry"])) {echo $_SESSION['errorcountry'];}
                                            ?>
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
                                    <div class="row pr-5 mb-5">
                                        <div class="fs-3">Type</div>
                                        <div><?php echo $_SESSION['type']['nom']?></div>
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
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="cgu"
                                                name="cgu" required>
                                            <label class="form-check-label" for="cgu">
                                                J'accepte les <a href="/cgu">CGU de The Arena</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class=" row mt-5 mb-3 pr-5">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="newsletter" name="newsletter">
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
                                                <input class="form-control" type="text" name="captcha"
                                                    placeholder="Captcha" required="required">
                                                <div class="invalid">
                                                    <?php if (isset($_SESSION['errorcaptcha'])) { echo $_SESSION['errorcaptcha']; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button id="continue" class="btn btn-primary">Continuer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
//TODO : Requête ajax + passage à la page suivante si tout est ok
let btn = document.getElementById('continue');

let form1 = document.getElementById("form1");
let form2 = document.getElementById("form2");
let form3 = document.getElementById("form3");
let check1 = document.getElementById("check1");
let check2 = document.getElementById("check2");
let check3 = document.getElementById("check3");

form2.setAttribute("hidden","");
form3.setAttribute("hidden","");

btn.addEventListener('click', clickHandler);

function clickHandler(event) {
    if (form1.getAttribute("hidden") == undefined && form2.getAttribute("hidden") == "") {
        form1.setAttribute("hidden","");
        form2.removeAttribute("hidden");
        form3.setAttribute("hidden","");
        check1.setAttribute("class","bi bi-check-circle-fill text-info");
        return;
    }
    
    if (form2.getAttribute("hidden") == undefined && form3.getAttribute("hidden") == "") {
        form1.setAttribute("hidden","");
        form2.setAttribute("hidden","");
        form3.removeAttribute("hidden");
        check3.setAttribute("class","bi bi-check-circle-fill text-info");
        btn.innerHTML = "M'inscrire";
        return btn.setAttribute("type", "submit");
    }
}
</script>
</body>

</html>