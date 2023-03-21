<?php 
    $requis="";
    $loginErr="";
    require 'verif.php';
    require 'header.php';
?>
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="on" method="post"> 
                <fieldset>
                    <legend> Se connecter</legend>
                    <p><span class="error"> * Champ requis.  </span></p>
                    <span class="error"><?php echo $requis; ?></span><br>
                    <label for="login"> Pseudonyme : </label><br>
                    <input type="text" name="login" placeholder="utilisateur" value="<?php echo $login; ?>" required>
                    <span class="error">* <?php echo $loginErr;?></span><br><br><br>
                    <label for="password">Mot de passe :</label><br>
                    <input type="password" name="password" placeholder="****************" value="<?php echo $password; ?>"required>
                    <span class="error">* <?php echo $passwordErr;?></span><br><br>
                
                    <input type="submit" value="Envoyer le formulaire">
                    <input type="reset">
                </fieldset>
            </form>
        </div>
        <div>
        <button class=' btn btn-primary'><a href='index.php'> index </a></button><br><br>
        </div>
        <?php require 'footer.php';