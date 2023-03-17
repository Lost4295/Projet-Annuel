<?php
session_start();
$login="";
$name="";
$lastname="";
$password="";
$loginErr="";
$nameErr="";
$lastnameErr=""; 
$passwordErr="";
require 'veriffirst.php'; ?>
<!DOCTYPE HTML>

<html>
    <head>
        <meta name="Page" content="Quelle page magnifique">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../style.css">
        <title>Formulaire d'inscription </title>
    </head>
    <body>
        <button class='styled'><a href='../index.php'> index </a></button><br><br>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="on" method="post"> 
                <fieldset>
                    <legend> S'inscrire</legend>
                    <p><span class="error">* Champ requis.</span></p>
                    <label for="name">Nom : </label><br>
                    <input type="text" name="name" placeholder="Doe" value="<?php echo $name; ?>" required>
                    <span class="error">* <br><?php echo $nameErr;?></span><br>
                    <label for="lastname">Prénom : </label><br>
                    <input type="text" name="lastname" placeholder="John" value="<?php echo $lastname; ?>" required>
                    <span class="error">*<br> <?php echo $lastnameErr;?></span><br><br>
                    <label for="login"> Pseudonyme : </label><br>
                    <input type="text" name="login" placeholder="utilisateur" value="<?php echo $login; ?>" required>
                    <span class="error">* <br><?php echo $loginErr;?></span><br><br>
                    <label for="password">Mot de passe :</label><br>
                    <input type="password" name="password" placeholder="****************" required><br>
                    <span class="error">* <?php echo $passwordErr;?></span><br><br>
                    <label for="gender"> Identité de genre :</label><br>
                    <input type="radio" name="gender" value="F" required >&nbsp;Femme&nbsp;</input>
                    <input type="radio" name="gender" value="M"required>&nbsp;Homme&nbsp;</input><br>
                </fieldset>
                <input type="submit" value="Envoyer le formulaire">
                <input type="reset">
            </form>
        </div>
    </body>
</html>