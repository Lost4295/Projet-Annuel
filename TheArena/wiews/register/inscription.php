<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<?php require $_SERVER['DOCUMENT_ROOT'] . '/core/functions.php';
session_start();
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
                    <span id="errors" class="alert alert-danger"></span>
                    <div class="col pr-5 mr-5">
                        <form action="/core/verify1.php" method="post">
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
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="confirmPwd" class="form-label">Confirmation du mot de passe</label>
                                        <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
                                    </div>
                                </div>
                            </div>
                            <div id="form2">
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" required placeholder="John">
                                    </div>
                                    <div class="col">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Doe">
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
                                        <label for="address" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" required placeholder="1 Rue de Paris">
                                    </div>
                                </div>
                                <div class=" row mt-5 mb-3 pr-5">
                                    <div class="col">
                                        <label for="cp" class="form-label">Code postal</label>
                                        <input type="text" class="form-control" id="cp" name="cp" required placeholder="75012">
                                    </div>
                                    <div class="col">
                                        <label for="city" class="form-label">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" required placeholder="Paris">
                                    </div>
                                    <div class="col">
                                        <label for="country" class="form-label">Pays</label>
                                        <input type="text" class="form-control" id="country" name="country" required placeholder="France">
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
                                        <div class="col">
                                            <img src="/wiews/register/captcha.php" width="100%">
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" name="captcha" placeholder="Captcha" required="required">
                                                <div class="invalid">
                                                    <?php if (isset($_SESSION['errorcaptcha'])) {
                                                        echo $_SESSION['errorcaptcha'];
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" id="continue" class="btn btn-primary">Continuer</button>
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
    function verifyValues1() {
        let type = document.querySelector('input[name="type"]:checked').value;
        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('pwd').value;
        let confirmPassword = document.getElementById('confirmpwd').value;
        if (type == "" || username == "" || email == "" || password == "" || confirmPassword == "") {
            alert("Veuillez remplir tous les champs.");
            return false;
        }

        return {
            type,
            username,
            email,
            password,
            confirmPassword

        }
    }

    function table1() {
        let type = document.querySelector('input[name="type"]:checked').value;
        if (type==1){
            type= "Joueur"
        } else {
            type= "Organisateur"
        }
        let username = document.getElementById('username').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('pwd').value;
        return {
            "Type": type,
            "Nom d'utilisateur": username,
            "E-mail": email,
            "Mot de passe": password,
        };
    }

    function table2() {
        let firstname = document.getElementById('firstname').value;
        let lastname = document.getElementById('lastname').value;
        let birthdate = document.getElementById('birthdate').value;
        let phonenumber = document.getElementById('phonenumber').value;
        let address = document.getElementById('address').value;
        let cp = document.getElementById('cp').value;
        let city = document.getElementById('city').value;
        let country = document.getElementById('country').value;
        return {
            "Prénom": firstname,
            "Nom": lastname,
            "Date d'anniversaire": birthdate,
            "Numéro de téléphone": phonenumber,
            "Adresse": address,
            "Code postal": cp,
            "Ville": city,
            "Pays": country
        }
    }

    function verifyValues2() {
        let firstname = document.getElementById('firstname').value;
        let lastname = document.getElementById('lastname').value;
        let birthdate = document.getElementById('birthdate').value;
        let phonenumber = document.getElementById('phonenumber').value;
        let address = document.getElementById('address').value;
        let cp = document.getElementById('cp').value;
        let city = document.getElementById('city').value;
        let country = document.getElementById('country').value;
        if (firstname == "" || lastname == "" || birthdate == "" || phonenumber == "" || address == "" || cp == "" || city == "" || country == "") {
            alert("Veuillez remplir tous les champs.");
            return false;
        }
        return {
            firstname,
            lastname,
            birthdate,
            phonenumber,
            address,
            cp,
            city,
            country
        }
    }



    //TODO : Requête ajax + passage à la page suivante si tout est ok
    let btn = document.getElementById('continue');
    let form1 = document.getElementById("form1");
    let form2 = document.getElementById("form2");
    let form3 = document.getElementById("form3");
    let check1 = document.getElementById("check1");
    let check2 = document.getElementById("check2");
    let check3 = document.getElementById("check3");
    let span = document.getElementById("errors");
    span.setAttribute("hidden", "");
    form2.setAttribute("hidden", "");
    form3.setAttribute("hidden", "");

    btn.addEventListener('click', clickHandler);

    function clickHandler(event) {
        if (form1.getAttribute("hidden") == undefined && form2.getAttribute("hidden") == "") {
            let form1values = verifyValues1();
            if (form1values) {
                fetch('/core/verify1.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(form1values)
                    }).then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);

                        if (data.length == 0) {
                            span.innerHTML = "";
                            span.setAttribute("hidden", "");
                            form1.setAttribute("hidden", "");
                            form2.removeAttribute("hidden");
                            form3.setAttribute("hidden", "");
                            check1.setAttribute("class", "bi bi-check-circle-fill text-info");
                            return;
                        } else {
                            span.removeAttribute("hidden");
                            span.innerHTML = " Il y a des erreurs. Merci de corriger les champs suivants :<ul>";
                            let errortype = data.errortype
                            let errorusername = data.errorusername
                            let erroremail = data.erroremail
                            let errorpwd = data.errorpwd
                            let errorpwdconfirm = data.errorpwdconfirm
                            if (errortype) {
                                span.innerHTML += "<li> Type : " + errortype + "</li>";
                            }
                            if (errorusername) {
                                span.innerHTML += "<li> Nom d'utilisateur : " + errorusername + "</li>";
                            }
                            if (erroremail) {
                                span.innerHTML += "<li> Email : " + erroremail + "</li>";
                            }
                            if (errorpwd) {
                                span.innerHTML += "<li> Mot de passe : " + errorpwd + "</li>";
                            }
                            if (errorpwdconfirm) {
                                span.innerHTML += "<li> Confirmation du mot de passe : " + errorpwdconfirm + "</li>";
                            }
                            span.innerHTML += "</ul> ";
                            return;
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            } else {
                return;
            }
        }

        if (form2.getAttribute("hidden") == undefined && form3.getAttribute("hidden") == "") {

            let form2values = verifyValues2();
            console.log("Nom: " + form2values.firstname);
            console.log("Prénom: " + form2values.lastname);
            console.log("Date de naissance: " + form2values.birthdate);
            console.log("Numéro de téléphone: " + form2values.phonenumber);
            console.log("Adresse: " + form2values.address);
            console.log("Code postal: " + form2values.cp);
            console.log("Ville: " + form2values.city);
            console.log("Pays: " + form2values.country);
            if (form2values) {
                fetch('/core/verify2.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(form2values)
                    }).then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        if (data.length == 0) {
                            span.innerHTML = "";
                            span.setAttribute("hidden", "");
                            form1.setAttribute("hidden", "");
                            form2.setAttribute("hidden", "");
                            form3.removeAttribute("hidden");
                            check3.setAttribute("class", "bi bi-check-circle-fill text-info");
                            btn.innerHTML = "M'inscrire";
                            const finalinfos = document.getElementById('finalinfos');

                            let firsttable = table1()
                            console.log(firsttable);
                            let secondtable = table2()
                            console.log(secondtable);
                            for (const key in firsttable) {
                                const h3 = document.createElement('h3');
                                const div = document.createElement('div');
                                h3.textContent = key;
                                div.textContent = firsttable[key];
                                finalinfos.appendChild(h3);
                                finalinfos.appendChild(div);
                            }
                            for (const key in secondtable) {
                                const h3 = document.createElement('h3');
                                const div = document.createElement('div');
                                h3.textContent = key;
                                div.textContent = secondtable[key];
                                finalinfos.appendChild(h3);
                                finalinfos.appendChild(div);
                            }
                            return btn.setAttribute("type", "submit");
                        } else {
                            span.removeAttribute("hidden");
                            span.innerHTML = " Il y a des erreurs. Merci de corriger les champs suivants :<ul>";
                            let errorfirstname = data.errorfirstname
                            let errorlastname = data.errorlastname
                            let errorbirthdate = data.errorbirthdate
                            let errorphonenumber = data.errorphonenumber
                            let erroraddress = data.erroraddress
                            let errorcp = data.errorcp
                            let errorcity = data.errorcity
                            let errorcountry = data.errorcountry
                            if (errorfirstname) {
                                span.innerHTML += "<li> Prénom : " + errorfirstname + "</li>";
                            }
                            if (errorlastname) {
                                span.innerHTML += "<li> Nom : " + errorlastname + "</li>";
                            }
                            if (errorbirthdate) {
                                span.innerHTML += "<li> Date de naissance : " + errorbirthdate + "</li>";
                            }
                            if (errorphonenumber) {
                                span.innerHTML += "<li> Numéro de téléphone : " + errorphonenumber + "</li>";
                            }
                            if (erroraddress) {
                                span.innerHTML += "<li> Adresse : " + erroraddress + "</li>";
                            }
                            if (errorcp) {
                                span.innerHTML += "<li> Code postal : " + errorcp + "</li>";
                            }
                            if (errorcity) {
                                span.innerHTML += "<li> Ville : " + errorcity + "</li>";
                            }
                            if (errorcountry) {
                                span.innerHTML += "<li> Pays : " + errorcountry + "</li>";
                            }
                            span.innerHTML += "</ul> ";
                            return;
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            } else {
                return;
            }
        }
    }
</script>
</body>

</html>