<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";


if (isset($_SESSION['email'])) {
    $db = connectToDB();
    $queryPrepared = $db->prepare("SELECT first_name, last_name FROM " . PREFIX . "users WHERE email=:email");
    $queryPrepared->execute(["email" => $_SESSION["email"]]);
    $result = $queryPrepared->fetch();
    $firstname = $result['first_name'];
    $lastname = $result['last_name'];
    closeConnectionToDB($db);
}
?>

<form action="/wiews/important/send.php" method="post">
    <div class="row">
        <div class="col mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="John" value="<?php if (isset($result['last_name'])) {
                                                                                                                echo cleanNames($result['last_name']);
                                                                                                            } ?>" <?php if (isset($result['last_name'])) {
                                                                                                                        echo "disabled";
                                                                                                                    } ?> required>
            <div class="invalid">
                <?php if (isset($_SESSION['errorlastname'])) {
                    echo $_SESSION['errorlastname'];
                } ?>
            </div>
        </div>
        <div class="col mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Doe" value="<?php if (isset($result['first_name'])) {
                                                                                                                    echo cleanNames($result['first_name']);
                                                                                                                } ?>" <?php if (isset($result['first_name'])) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?> required>
            <div class="invalid">
                <?php if (isset($_SESSION['errorfirstname'])) {
                    echo $_SESSION['errorfirstname'];
                } ?>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php if (isset($_SESSION['email'])) {
                                                                                                                        echo $_SESSION['email'];
                                                                                                                    } ?>" <?php if (isset($_SESSION['email'])) {
                                                                                                                                echo "disabled";
                                                                                                                            } ?> required>
            <div class="invalid">
                <?php if (isset($_SESSION['erroremail'])) {
                    echo $_SESSION['erroremail'];
                } ?>
            </div>
        </div>
        <div class="col mb-3">
            <label for="type" class="form-label">Type de demande</label>
            <select class="form-select col mb-3" id="type" name="type" aria-label="Type de demande" required>
                <option value="" selected disabled>Type de demande</option>
                <option value="1">Assistance</option>
                <option value="2">Réclamation</option>
                <option value="3">Effacer mes données</option>
                <option value="4">Autre</option>
            </select>
            <div class="invalid">
                <?php if (isset($_SESSION['errortype'])) {
                    echo $_SESSION['errortype'];
                } ?>
            </div>
        </div>
    </div>
    <div class="mb-5">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5"></textarea>
    </div>
    <div class="invalid">
        <?php if (isset($_SESSION['errormessage'])) {
            echo $_SESSION['errormessage'];
        } ?>
    </div>

    <span id="passwordHelpInline" class="form-text mb-3">
        En soumettant ce formulaire, vous acceptez que le site The Arena mémorise et utilise vos données personnelles afin de pouvoir vous contacter.
        L’éditeur du site s’engage à ne pas transmettre vos coordonnées à quelconque tiers ni les utiliser pour de la publicité.
    </span>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" value="1" id="check" required>
        <label class="form-check-label" for="check">
            J’autorise The Arena à communiquer avec moi par email.
        </label>
    </div>
    <div class="mb-5 d-flex justify-content-center">
        <input class="btn btn-primary btn-lg" type="submit" value="Envoyer le formulaire">
    </div>

</form>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php" ?>