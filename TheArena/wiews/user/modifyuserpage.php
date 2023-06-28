<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";
redirectIfNotConnected();

require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
$connection = connectToDB();
$queryPrepared = $connection->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
$queryPrepared->execute([
    "email" => $_SESSION["email"]
]);

$result = $queryPrepared->fetch(PDO::FETCH_ASSOC);
if (!empty($result)) {
    $firstname = $result["first_name"];
    $lastname = $result["last_name"];
    $username = $result["username"];
    $birthdate = $result["birthdate"];
    $email = $result["email"];
    $address = $result["address"];
    $password = $result["password"];
    $scope = $result["scope"];
    $phone = $result["phone"];
    $newsletter = $result["newsletter"];
    $avatar = $result["avatar"];
    $about = $result["about"];
}

?>

<div class="w-100">
    <h1> Modifier ma page </h1>

    <div class=" row mt-5 mb-3 pr-5 -flex justify-content-between">
    </div>
    <div class=" row mt-5 mb-3 pr-5 -flex justify-content-between">
        <div class="col-4">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" disabled value="<?php echo cleanNames($firstname) ?>">
        </div>
        <div class="col-4">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" disabled value="<?php echo cleanNames($lastname) ?>">
        </div>
    </div>
    <div class="row d-flex justify-content-between">
        <div class="col-5 mb-3">
            <label for="birthdate" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="birthdate" value="<?php echo $birthdate ?>" disabled>
        </div>
        <div class="col-5 mb-3">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="text" class="form-control" id="phone" value="<?php echo $phone ?>" disabled>
        </div>
    </div>
    <div class="col my-4">
        <label for="adresss" class="form-label">Adresse</label>
        <input type="text" class="form-control" id="adresss" name="adresss" value="<?php echo $address; ?>" disabled>
    </div>
    <p class="text-muted text-center"> Ces informations ne sont pas modifiables. Afin de pouvoir les modifier, merci de contacter un administrateur.</p>
    <form action="/wiews/user/verifyuserpage.php" method="post" enctype="multipart/form-data">
        <div class="col-7 my-4">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $username; ?>">

            <div class="invalid">
                <?php if (isset($_SESSION["errorpseudo"])) {
                    echo $_SESSION["errorpseudo"];
                } ?>
            </div>
        </div>
        <div class="col-7 my-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">

            <div class="invalid">
                <?php if (isset($_SESSION["erroremail"])) {
                    echo $_SESSION["erroremail"];
                } ?>
            </div>
        </div>
        <div class="col-7 my-4">
            <label for="pwd" class="form-label">Mot de passe</label>
            <div class="input-group mb-3">
                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" autocomplete="new-password">
                <button type="button" class="input-group-text" id="pwd-eye"><i class="bi bi-eye-slash-fill"></i></button>
            </div>
            <div class="invalid">
                <?php if (isset($_SESSION["errorpwd"])) {
                    echo $_SESSION["errorpwd"];
                } ?>
            </div>
        </div>
        <div class="col-7 my-4">
            <label for="confirmpwd" class="form-label">Confirmation du mot de passe</label>
            <div class="input-group mb-3">
                <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" autocomplete="new-password">
                <button type="button" class="input-group-text" id="confpwd-eye"><i class="bi bi-eye-slash-fill"></i></button>
            </div>
            <div class="invalid">
                <?php if (isset($_SESSION["errorpwdconfirm"])) {
                    echo $_SESSION["errorpwdconfirm"];
                } ?>
            </div>
        </div>
        <div class=" row mt-5 mb-3 pr-5">
            <div class="col">
                <h4>Photo de profil</h4>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="chooser">
                    <label class="form-check-label" for="chooser" id="texte">Image utilisateur</label>
                </div>
                <div id="customimg" class="images">
                    <label for="image" class="d-flex justify-content-center">
                        <div class=" my-5">
                            <img src="<?php echo $avatar ?>" width="150" height="150" id="output" />
                        </div>
                    </label>
                    <input type="file" id="image" accept="image/png, image/jpeg, image/jpg" name="avatar" onchange="loadFile(event)">
                </div>
                <div id="customavatar" style="display:none">

                    <div class="panels">
                        <div class="panel-left"></div>
                        <div class="panel">
                            <div class="avatar-customizer">
                                <div class="arrows left">
                                    <div class="arrow left" onclick="changeAttr(id)" id="0" data-avatar-index="1"></div>
                                    <div class="arrow left" onclick="changeAttr(id)" id="1" data-avatar-index="2"></div>
                                    <div class="arrow left" onclick="changeAttr(id)" id="2" data-avatar-index="0"></div>
                                </div>
                                <div class="container">
                                    <div class="avatar fit">
                                        <div class="color" style="background-position: 0% 0%;"></div>
                                        <div class="eyes" style="background-position: 0% 0%;"></div>
                                        <div class="mouth" style="background-position: 0% 0%;"></div>
                                        <div class="special" style="display: none;"></div>
                                        <div class="owner" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="arrows right">
                                    <div class="arrow right" onclick="changeAttr(id)" id="3" data-avatar-index="1"></div>
                                    <div class="arrow right" onclick="changeAttr(id)" id="4" data-avatar-index="2"></div>
                                    <div class="arrow right" onclick="changeAttr(id)" id="5" data-avatar-index="0"></div>
                                </div>
                                <div class="randomize" data-tooltip="Randomize your Avatar!" data-tooltipdir="N"></div>
                            </div>
                        </div>
                        <div class="panel-right">
                            <button type="button" id="crowned">Ajouter/retirer la couronne</button>
                            <button type="button" id="specialed"  hidden >Toogle special</button>
                            <div class="d-flex align-items-center justify-content-around invisible" id="buttons">
                                <div class="arrows left">
                                    <div class="arrow left" onclick="changeSpec(id)" id="6" style="filter: drop-shadow(0 0 3px rgba(0, 0, 0, .15));flex: 0 0 auto;cursor: pointer;width: 34px;height: 34px;background-image: url(https://skribbl.io/img/arrow.gif);background-size: 200%;background-repeat: no-repeat;background-position: 0% 0%;"></div>
                                </div>
                                <div class="arrows right">
                                    <div class="arrow right" onclick="changeSpec(id)" id="7" style="filter: drop-shadow(0 0 3px rgba(0, 0, 0, .15));flex: 0 0 auto;cursor: pointer;width: 34px;height: 34px;background-image: url(https://skribbl.io/img/arrow.gif);background-size: 200%;background-repeat: no-repeat;background-position: 0% 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        var larrows = document.querySelectorAll('.arrows .left');
                        var rarrows = document.querySelectorAll('.arrows .right');
                        let posie = 0;
                        let posmo = 0;
                        let poscol = 0;
                        let minie = 0;
                        let maxie = 58;
                        let minmo = 0;
                        let maxmo = 52;
                        let mincol = 0;
                        let maxcol = 28;
                        let crowned = document.getElementById("crowned");
                        let crown = document.getElementsByClassName("owner")[0];
                        let posspe = 0;

                        crowned.addEventListener('click', function() {
                            if (crown.style.display == "none") {
                                crown.style.display = "block";
                                valuesToSave.owner = 'true';
                            } else {
                                crown.style.display = "none";
                                valuesToSave.owner = 'false';
                            }
                            document.getElementById("avatarvals").value = JSON.stringify(valuesToSave)
                        })
                        let specialed = document.getElementById("specialed");
                        let special = document.getElementsByClassName("special")[0];
                        let specialBtns = document.getElementById("buttons");

                        specialed.addEventListener('click', function() {
                            if (special.style.display == "none") {
                                special.style.display = "block";
                                specialBtns.classList.remove("invisible");
                                valuesToSave.special = '0';
                            } else {
                                special.style.display = "none";
                                specialBtns.classList.add("invisible");
                                valuesToSave.special = 'false';
                            }
                            document.getElementById("avatarvals").value = JSON.stringify(valuesToSave)
                        })
                        function changeSpec(id) {
                            var elem = document.getElementById(id)
                            if (id == 7) {
                                if (posspe < specialPositions.length - 1) {
                                    posspe++
                                } else {
                                    posspe = 0
                                }
                            } else if (id == 6) {
                                if (posspe > 0) {
                                    posspe--
                                } else {
                                    posspe = specialPositions.length - 1
                                }
                            }
                            special.style.backgroundPosition = specialPositions[posspe]
                            valuesToSave.special = posspe
                            document.getElementById("avatarvals").value = JSON.stringify(valuesToSave)
                        }

                        let randomize = document.getElementsByClassName("randomize")[0]
                        randomize.addEventListener('click', function() {
                            posie = Math.floor(Math.random() * (maxie - minie)) + minie;
                            posmo = Math.floor(Math.random() * (maxmo - minmo)) + minmo;
                            poscol = Math.floor(Math.random() * (maxcol - mincol)) + mincol;
                            changeAttr(0)
                            changeAttr(1)
                            changeAttr(2)
                        })

                        let valuesToSave = {
                            color: 0,
                            eyes: 0,
                            mouth: 0,
                            special: 'false',
                            owner: 'false'
                        }

                        function changeAttr(id) {
                            var elem = document.getElementById(id)
                            var index = elem.dataset.avatarIndex
                            var color = document.getElementsByClassName("color")[0]
                            var eyes = document.getElementsByClassName("eyes")[0]
                            var mouth = document.getElementsByClassName("mouth")[0]
                            switch (index) {
                                case '0':
                                    if (eyes.classList.contains("avatar-clicked")) {
                                        eyes.classList.remove("avatar-clicked")
                                    }
                                    if (mouth.classList.contains("avatar-clicked")) {
                                        mouth.classList.remove("avatar-clicked")
                                    }
                                    if (special.classList.contains("avatar-clicked")) {
                                        special.classList.remove("avatar-clicked")
                                    }
                                    color.classList.add("avatar-clicked")
                                    if (id == 5) {
                                        if (poscol < colorPositions.length - 1) {
                                            poscol++
                                        } else {
                                            poscol = 0
                                        }
                                    } else if (id == 2) {
                                        if (poscol > 0) {
                                            poscol--
                                        } else {
                                            poscol = colorPositions.length - 1
                                        }
                                    }
                                    color.style.backgroundPosition = colorPositions[poscol]
                                    break;
                                case '1':
                                    if (color.classList.contains("avatar-clicked")) {
                                        color.classList.remove("avatar-clicked")
                                    }
                                    if (mouth.classList.contains("avatar-clicked")) {
                                        mouth.classList.remove("avatar-clicked")
                                    }
                                    if (special.classList.contains("avatar-clicked")) {
                                        special.classList.remove("avatar-clicked")
                                    }
                                    eyes.classList.add("avatar-clicked")
                                    if (id == 3) {
                                        if (posie < eyesPositions.length - 1) {
                                            posie++
                                        } else {
                                            posie = 0
                                        }
                                    } else if (id == 0) {
                                        if (posie > 0) {
                                            posie--
                                        } else {
                                            posie = eyesPositions.length - 1
                                        }
                                    }
                                    eyes.style.backgroundPosition = eyesPositions[posie]
                                    break;
                                case '2':
                                    if (color.classList.contains("avatar-clicked")) {
                                        color.classList.remove("avatar-clicked")
                                    }
                                    if (eyes.classList.contains("avatar-clicked")) {
                                        eyes.classList.remove("avatar-clicked")
                                    }
                                    if (special.classList.contains("avatar-clicked")) {
                                        special.classList.remove("avatar-clicked")
                                    }
                                    mouth.classList.add("avatar-clicked")

                                    if (id == 4) {
                                        if (posmo < mouthPositions.length - 1) {
                                            posmo++
                                        } else {
                                            posmo = 0
                                        }
                                    } else if (id == 1) {
                                        if (posmo > 0) {
                                            posmo--
                                        } else {
                                            posmo = mouthPositions.length - 1
                                        }
                                    }
                                    mouth.style.backgroundPosition = mouthPositions[posmo]
                                    break;
                                default:
                                    break;
                            }
                            valuesToSave.color = poscol
                            valuesToSave.eyes = posie
                            valuesToSave.mouth = posmo
                            document.getElementById("avatarvals").value = JSON.stringify(valuesToSave)
                        }
// TODO trouver toutes les valeurs en px ! 132 = 100
                        let eyesPositions = ["0px 0px", "132px 0px", "272px 0px", "407px 0px", "543px 0px", "680px 0px", '817px 0px', '950px 0px', '1087px 0px', '1223px 0px',
                            "0px -132px", "-134px -134px", "-272px -132px", "-407px -132px", "-543px -132px", "-680px -132px", '-817px -132px', '-950px -132px', '-1087px -132px', '-1223px -132px',
                            "0px -260px", "-132px -260px", "-272px -260px", "-407px -260px", "-543px -260px", "-680px -260px", '-817px -260px', '-950px -260px', '-1087px -260px', '-1223px -260px',
                            "0px -386px", "-132px -386px", "-272px -386px", "-407px -386px", "-543px -386px", "-680px -386px", '-817px -386px', '-950px -386px', '-1087px -386px', '-1223px -386px',
                            "0px -520px", "-132px -520px", "-272px -520px", "-407px -520px", "-543px -520px", "-680px -520px", '-817px -520px', '-950px -520px', '-1087px -520px', '-1223px -520px',
                            "0px -650px", "-132px -650px", "-272px -650px", "-407px -650px", "-543px -650px", "-680px -650px", '-817px -650px'
                        ]

                        let specialPositions = ["0px -8px", "225px -8px", "450px -8px", "680px -8px", "901px -2px", "1125px -2px", '1350px 2px', '1577px 2px', '1802px -8px', '2029px -8px',
                            "0px -207px", "-225px -207px", "-450px -207px", "-680px -207px", "-901px -207px", "-1125px -207px", '-1350px -207px', '-1577px -207px', '-1802px -207px', '-2029px -207px',
                            "-407px -264px", "-543px -264px", '-680px -264px', '-817px -264px', "-1223px 207px", "-1087px 207px", "-950px 207px ", "-817px 207px "
                        ]

                        let mouthPositions = ["0px 0px", "132px 0px", "272px 0px", "407px 0px", "543px 0px", "680px 0px", '817px 0px', '950px 0px', '1087px 0px', '1223px 0px',
                            "0px -132px", "-132px -132px", "-272px -132px", "-407px -132px", "-543px -132px", "-680px -132px", '-817px -132px', '-950px -132px', '-1087px -132px', '-1223px -132px',
                            "0px -264px", "-132px -264px", "-264px -264px", "-407px -264px", "-543px -264px", "-680px -264px", '-817px -264px', '-950px -264px', '-1087px -264px', '-1223px -264px',
                            "0px -390px", "-136px -390px", "-272px -390px", "-407px -390px", "-543px -390px", "-680px -390px", '-817px -390px', '-950px -390px', '-1087px -390px', '-1223px -390px',
                            "0px -520px", "-136px -520px", "-272px -520px", "-407px -520px", "-543px -520px", "-680px -520px", '-817px -520px', '-950px -520px', '-1087px -520px', '-1223px -520px',
                            "0px -650px"
                        ]

                        let colorPositions = ["0px 0px", "135px 0px", "272px 0px", "407px 0px", "543px 0px", "680px 0px", '817px 0px', '950px 0px', '1087px 0px', '1223px 0px',
                            "0px -130px", "-135px -130px", "-272px -130px", "-407px -130px", "-543px -130px", "-680px -130px", '-817px -130px', '-950px -130px', '-1087px -130px', '-1223px -130px',
                            "0px -260px", "-135px -260px", "-272px -260px", "-407px -260px", "-543px -260px", "-680px -260px", "0px -390px"
                        ]
                    </script>
                    <input type="hidden" name="avatarvals" id="avatarvals" value="undefined">
                </div>

                <style>
                    .images img {
                        border-radius: 50%;
                        cursor: pointer;
                        border: 1px solid black;
                    }

                    .images>input {
                        display: none;
                    }
                </style>
                <script>
                    let choosetypeimage = document.getElementById("chooser");
                    let customimg = document.getElementById("customimg");
                    let customavatar = document.getElementById("customavatar");

                    choosetypeimage.onclick = function() {
                        if (choosetypeimage.checked == true) {
                            customimg.style.display = "none";
                            customavatar.style.display = "block";
                            document.getElementById("texte").innerHTML = "Avatar personnalisé";

                        } else {
                            customimg.style.display = "block";
                            customavatar.style.display = "none";
                            document.getElementById("texte").innerHTML = "Image utilisateur";
                        }
                    }
                    var loadFile = function(event) {
                        var output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                    };

                    let eye = document.getElementById("pwd-eye");
                    let confeye = document.getElementById("confpwd-eye");
                    let pwd = document.getElementById("pwd");
                    let confirmpwd = document.getElementById("confirmpwd");
                    console.log(eye);
                    eye.addEventListener("click", function() {
                        if (pwd.type === "password") {
                            pwd.type = "text";
                            confirmpwd.type = "password";
                            confeye.innerHTML = "<i class='bi bi-eye-slash-fill'></i>";
                            eye.innerHTML = "<i class='bi bi-eye-fill'></i>";
                        } else {
                            pwd.type = "password";
                            eye.innerHTML = "<i class='bi bi-eye-slash-fill'></i>";
                        }
                    })
                    confeye.addEventListener("click", function() {
                        if (confirmpwd.type === "password") {
                            confirmpwd.type = "text";
                            confeye.innerHTML = "<i class='bi bi-eye-fill'></i>";
                            pwd.type = "password";
                            eye.innerHTML = "<i class='bi bi-eye-slash-fill'></i>";
                        } else {
                            confirmpwd.type = "password";
                            confeye.innerHTML = "<i class='bi bi-eye-slash-fill'></i>";
                        }

                    })
                </script>
                <div class="invalid">
                    <?php if (isset($_SESSION["erroravatar"])) {
                        echo $_SESSION["erroravatar"];
                    } ?>
                </div>
                <script>
                    function example() {
                        el = document.getElementById("example");
                        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
                    }
                </script>

                <div class="mb-5 pb-5">
                    <label for="about" class="form-label">
                        <h3>À propos de moi</h3>
                    </label>
                    <textarea class="form-control" id="about" rows="3" name="about"><?php echo $about ?></textarea>

                    <div class="invalid">
                        <?php if (isset($_SESSION["errorabout"])) {
                            echo $_SESSION["errorabout"];
                        } ?>
                    </div>
                </div>
                <div class="mb-5 pb-5">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="newsletter" id="newslettter" <?php if ($newsletter == 1) {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                        <label class="form-check-label" for="newslettter">
                            Je m'abonne aux newsletters
                        </label>
                    </div>
                </div>
                <div class="mb-5 pb-5">
                    <label class="form-check-label" for="visibility">
                        Visibilité du compte
                    </label>
                    <select class="form-select" name="visibility" aria-label="visibility" id="visibility">
                        <option value="2" <?php if ($result['visibility'] == 2) {
                                                echo "selected";
                                            } ?>>Public</option>
                        <option value="1" <?php if ($result['visibility'] == 1) {
                                                echo "selected";
                                            } ?>>Privé</option>
                    </select>
                    <div class="invalid">
                        <?php if (isset($_SESSION["errorvisibility"])) {
                            echo $_SESSION["errorvisibility"];
                        } ?>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $result["id"] ?>">
                <div class="d-flex justify-content-center">
                    <input type="submit" value="Enregistrer les modifications" class="btn btn-primary ">
                </div>
    </form>
</div>
</div>
</div>
</div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>