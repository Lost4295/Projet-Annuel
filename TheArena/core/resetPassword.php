<?php
require $_SERVER['DOCUMENT_ROOT'] . '/core/header.php';
define('LOGIN', 'Location: /login');

if (isset($_GET['activationCode']) && isset($_GET['email'])) {
    $activationCode = $_GET['activationCode'];
    $email = $_GET['email'];
    $db = connectToDB();
    $query = $db->prepare("SELECT * FROM " . PREFIX . "users WHERE email=:email");
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
if ($activationCode != $user['activation_code']) {
        $_SESSION['message'] = "Le code d'activation n'est pas bon. Merci de réesayer.";
        $_SESSION['message_type'] = "danger";
        header(LOGIN);
    }
} else {
    $_SESSION['message'] = "Methode.";
    $_SESSION['message_type'] = "danger";
    header(LOGIN);
}

if (isset($_POST)) {
    if (isset($_POST['password']) && isset($_POST['passwordConf'])) {
        $pwd = $_POST['password'];
        $confirmpwd = $_POST['passwordConf'];
        if (strlen($pwd) < 8 || !preg_match("#[a-z]#", $pwd) || !preg_match("#[A-Z]#", $pwd) || !preg_match("#[\d]#", $pwd)) {
            $errors[] = "
        Votre mot de passe doit faire au minimum 8 caractères avec des minuscules,
        des majuscules et des chiffres.";
        }
        if ($pwd != $confirmpwd) {
            $errors[] = "Le mot de passe n'est pas bien copié.";
        }
        if (empty($errors)) {
            $db = connectToDB();
            $query = $db->prepare("UPDATE " . PREFIX . "users SET password=:password WHERE email=:email");
            $query->execute(['password' => password_hash($pwd, PASSWORD_DEFAULT), 'email' => $email ?? $_SESSION['email']]);
            header(LOGIN);
        }
    }
}





?>
<h1>Réinitialisation du mot de passe</h1>
<?php
if (!empty($errors)) {
    echo '<div class="alert alert-danger" role="alert">Il y a des choses à corriger. <ul>';
    foreach ($errors as $error) {
        echo "<li>" . $error . '</li>';
    }
    echo '</ul></div>';
}
?>
<form method="post">
    <div class="row">
        <div class="col mb-4">
            <label class="form-label" for="password">Nouveau mot de passe</label>
            <input type="password" class="form-control" name="password" placeholder="Nouveau mot de passe" required>
        </div>
    </div>
    <div class="row">
        <div class="col mb-4">
            <label class="form-label" for="passwordConf">Confirmer le mot de passe</label>
            <input type="password" class="form-control" name="passwordConf" placeholder="Confirmer le mot de passe" required>
        </div>
    </div>
    <div class="row">
        <div class="col mb-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>



<?php
require $_SERVER['DOCUMENT_ROOT'] . '/core/footer.php';
?>