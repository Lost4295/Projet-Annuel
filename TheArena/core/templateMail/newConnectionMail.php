<?php require "headerMail.php" ?>
    <div class='div-container'>
        <div class='row'>
            <p>Bonjour pseudo,<br> Cet e-mail a été créé car une nouvelle connexion au compte pseudo a été établie le 19 septembre 2022 04:03:00 PDT (19 septembre 2022 11:03:00 UTC) depuis :<br>
            <li>
                <ul>Lieu : <br></ul>
                <ul>appareil : <br></ul>
                <ul>Navigateur : <br></ul>
                <ul>Adresse IP : <br></ul>
            </li></p>
        </div>

        <div class='row'>
            <a class='btn btn-warning' href='#'>Réinitialiser le mot de passe</a>
        </div>
        <div class='row'>
            <p>
                Si vous êtes à l'origine de cette connexion, pas de problème ! Nous voulions juste vérifier qu'il s'agissait de vous.<br>
            </p>
            <p>
                Si vous n'êtes pas à l'origine de cette connexion, vous devez immédiatement changer votre mot de passe sur The Arena pour assurer la sécurité de votre compte.
            </p>
        </div>
    </div>
<?php require "footerMail.php"?>