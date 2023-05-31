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
    print_r($result);
    $firstname = $result["first_name"];
    $lastname = $result["last_name"];
    $username = $result["username"];
    $birthdate = $result["birthdate"];
    $email = $result["email"];
    $password = $result["password"];
    $scope = $result["scope"];
    $phone = $result["phone"];
    $address = $result["address"];
    $postal_code = $result["postal_code"];
    $country = $result["country"];
    $newsletter = $result["newsletter"];
    $avatar = $result["avatar"];
    $about = $result["about"];
}

print_r($_SESSION)

?>

<div class="w-100">
    <h1> Modifier ma page </h1>

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
            <input type="text" class="form-control" id="pwd" name="pwd" value="Johndoe1234">

            <div class="invalid">
                <?php if (isset($_SESSION["errorpwd"])) {
                    echo $_SESSION["errorpwd"];
                } ?>
            </div>
        </div>
        <div class="col-7 my-4">
            <label for="confirmpwd" class="form-label">Confirmation du mot de passe</label>
            <input type="password" class="form-control" id="confirmpwd" name="confirmpwd" value="Johndoe1234">

            <div class="invalid">
                <?php if (isset($_SESSION["errorpwdconfirm"])) {
                    echo $_SESSION["errorpwdconfirm"];
                } ?>
            </div>
        </div>
        <h4>Photo de profil</h4>
        <div class="images">
            <label for="image" class="d-flex justify-content-center">
                <div class=" my-5">
                    <img src="<?php echo $avatar ?>" width="150" height="150" id="output" />

                </div>
            </label>
            <input type="file" id="image" accept="image/png, image/jpeg, image/jpg" name="avatar" onchange="loadFile(event)">
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
            var loadFile = function(event) {
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
        <p class="text-muted text-center"> Cliquer pour modifier l'avatar</p>
        <div class="invalid">
            <?php if (isset($_SESSION["erroravatar"])) {
                echo $_SESSION["erroravatar"];
            } ?>
        </div>
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


<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>