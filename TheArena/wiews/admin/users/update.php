<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/functions.php";


$db = connectToDB();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE `id`=:id;");
    $query->execute([':id' => $id]);
    $user = $query->fetch();
    $scope = $user['scope'];
    $attr = whoIsConnected();
    if ($attr[0] == SUPADMIN || $scope != SUPADMIN) {
    } else {
        $_SESSION['message'] = "Vous n'êtes pas autorisé à modifier cet élément.";
        $_SESSION['message_type'] = "danger";
        header("Location: /admin/users");
    }
}
$db = connectToDB();
$query = $db->prepare("SELECT scope FROM " . PREFIX . "users WHERE email = :email");
$query->execute(['email' => $_SESSION['email']]);
$admin = $query->fetch(PDO::FETCH_ASSOC);
require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/header.php";
//FIXME le js passe pas 
?>

<form method="post" action="verifyusersup.php">
    <div class="row mt-3 mb-2 pr-5">
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
                <div class="form-check-inline form-check">
                    <input class="form-check-input" type="radio" name="type" value="3" id="admin">
                    <label class="form-check-label" for="organizer">
                        Administrateur
                    </label>
                </div>
                <div class="form-check-inline form-check">
                    <input class="form-check-input" type="radio" name="type" value="4" id="supadmin" <?php if ($admin['scope'] != SUPADMIN) echo "disabled" ?>>
                    <label class="form-check-label" for="organizer">
                        Super Administrateur
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-2 pr-5">
        <div class="col">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" id="username" value="<?php echo $user["username"] ?>" required>
        </div>
    </div>
    <div class="row mt-3 mb-2 pr-5">
        <div class="col">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="john@doe.com" value="<?php echo $user["email"] ?>" required>
        </div>
    </div>
    <div class="row mt-3 mb-2 pr-5">
        <div class="col">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
        </div>
    </div>
    <div class="row mt-3 mb-2 pr-5">
        <div class="col">
            <label for="confirmPwd" class="form-label">Confirmation du mot de passe</label>
            <input type="password" name="confirmpwd" class="form-control" id="confirmpwd" placeholder="Choisissez un mot de passe sécurisé. (8 caractères, dont majuscules, minuscules et chiffres)" required>
        </div>
    </div>
    <div class="row mt-3 mb-2 pr-5">
        <div class="col">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user["first_name"] ?>" required placeholder="John">
        </div>


        <div class="col">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user["last_name"] ?>" required placeholder="Doe">
        </div>
    </div>
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <label for="birthdate" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required placeholder="John" value="<?php echo $user["birthdate"] ?>">
        </div>
        <div class="col">
            <label for="phonenumber" class="form-label">Numéro de téléphone</label>
            <input type="tel" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $user["phone"] ?>" required placeholder="0xxxxxxxxx">
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
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
    </div>
    <div class="col-12">
        <button id="continue" class="btn btn-primary">Continuer</button>
    </div>
</form>
<script type="text/javascript" src="/wiews/admin/users/completer.js"></script>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/wiews/admin/footer.php";
