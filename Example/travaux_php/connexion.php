<?php 
    $requis="";
    $loginErr="";
    require 'verif.php';
    require 'header.php';
?>
        <div class="d-flex justify-content-center">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" autocomplete="on" method="post"> 
                    <legend> Se connecter</legend>
                    
                    <p><span class="error"> * Champ requis.  </span></p>
                    <span class="error"><?php echo $requis; ?></span><br>
                    <div class="mb-3">
                        <label class="form-label" for="login"> Pseudonyme : </label>
                        <input type="text" name="login" class="form-control" placeholder="utilisateur" value="<?php echo $login; ?>" required>
                    </div>
                    <span class="error">* <?php echo $loginErr;?></span><br><br><br>
                    <div class="mb-3">
                        <label class="form-label" for="password">Mot de passe :</label><br>
                        <input type="password" name="password" class="form-control" placeholder="****************" value="<?php echo $password; ?>"required>
                    </div>
                        <span class="error">* <?php echo $passwordErr;?></span><br><br>
                    <input type="submit" value="Envoyer le formulaire" class="btn btn-primary">
                    <input type="reset" class="btn btn-primary">
            </form>
        </div>
        <?php require 'footer.php';